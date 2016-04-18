<?php

namespace Vinci\App\Cms\Http\Country;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Country\CountryRepository;
use Vinci\Domain\Country\CountryService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Infrastructure\Country\Datatables\CountryCmsDatatable;

class CountryController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = CountryCmsDatatable::class;

    protected $imageRepository;

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        CountryService $service,
        CountryRepository $repository,
        ImageRepository $imageRepository,
        ACLService $aclService
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->imageRepository = $imageRepository;
        $this->aclService = $aclService;
    }

    public function index()
    {
        return $this->view('countries.list');
    }

    public function create()
    {
        return $this->view('countries.create');
    }

    public function edit($id)
    {
        $country = $this->repository->findOrFail($id);

        return $this->view('countries.edit')
            ->withCountry($country);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['image_map'] = $request->file('image_map');
            $data['image_banner'] = $request->file('image_banner');
            $data['user'] = cmsUser();

            $country = $this->service->create($data);

            Flash::success("País {$country->getName()} criado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $country->getId());

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
            $data['image_map'] = $request->file('image_map');
            $data['image_banner'] = $request->file('image_banner');
            $data['user'] = cmsUser();

            $country = $this->service->update($data, $id);

            Flash::success("País {$country->getName()} atualizado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $country->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $country = $this->repository->find($id);

        try {

            $this->repository->delete($country);

            Flash::success("País {$country->getName()} excluído com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function removeImage($countryId, $imageId)
    {
        try {

            $country = $this->repository->find($countryId);
            $image = $this->imageRepository->find($imageId);

            $this->service->removeImage($image, $country);

            Flash::success("Imagem excluída com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$countryId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

}