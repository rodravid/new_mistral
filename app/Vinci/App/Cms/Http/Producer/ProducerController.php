<?php

namespace Vinci\App\Cms\Http\Producer;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Producer\ProducerRepository;
use Vinci\Domain\Producer\ProducerService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Region\RegionRepository;
use Vinci\Infrastructure\Producer\Datatables\ProducerCmsDatatable;

class ProducerController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = ProducerCmsDatatable::class;

    protected $imageRepository;

    protected $aclService;

    protected $regionRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProducerService $service,
        ProducerRepository $repository,
        RegionRepository $regionRepository,
        ImageRepository $imageRepository,
        ACLService $aclService
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->imageRepository = $imageRepository;
        $this->aclService = $aclService;
        $this->regionRepository = $regionRepository;
    }

    public function index()
    {
        return $this->view('producers.list');
    }

    public function create()
    {
        $regions = $this->getRegionsSelectArray();

        return $this->view('producers.create')
            ->withRegions($regions);
    }

    public function edit($id)
    {
        $producer = $this->repository->findOrFail($id);
        $regions = $this->regionRepository->getAll();

        return $this->view('producers.edit')
            ->withProducer($producer)
            ->withRegions($regions);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['image_logo'] = $request->file('image_logo');
            $data['image_logo_mobile'] = $request->file('image_logo_mobile');
            $data['user'] = cmsUser();

            $producer = $this->service->create($data);

            Flash::success("Produtor {$producer->getName()} criado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $producer->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $data = $request->all();
            $data['image_logo'] = $request->file('image_logo');
            $data['image_logo_mobile'] = $request->file('image_logo_mobile');
            $data['user'] = cmsUser();

            $producer = $this->service->update($data, $id);

            Flash::success("Produtor {$producer->getName()} atualizado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $producer->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $producer = $this->repository->find($id);

        try {

            $this->repository->delete($producer);

            Flash::success("Produtor {$producer->getName()} excluído com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function removeImage($producerId, $imageId)
    {
        try {

            $producer = $this->repository->find($producerId);
            $image = $this->imageRepository->find($imageId);

            $this->service->removeImage($image, $producer);

            Flash::success("Imagem excluída com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$producerId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    protected function getRegionsSelectArray()
    {
        $regions = $this->regionRepository->getAll();
        return html_select_array($regions, 'id', 'name');
    }

}