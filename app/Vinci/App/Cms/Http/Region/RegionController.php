<?php

namespace Vinci\App\Cms\Http\Region;

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
use Vinci\Domain\Region\RegionRepository;
use Vinci\Domain\Region\RegionService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Infrastructure\Region\Datatables\RegionCmsDatatable;

class RegionController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $countryRepository;

    protected $datatable = RegionCmsDatatable::class;

    protected $imageRepository;

    public function __construct(
        EntityManagerInterface $em,
        RegionService $service,
        RegionRepository $repository,
        CountryRepository $countryRepository,
        ImageRepository $imageRepository
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->imageRepository = $imageRepository;
        $this->countryRepository = $countryRepository;
    }

    public function index()
    {
        return $this->view('regions.list');
    }

    public function create()
    {
        $countries = $this->getCountriesSelectArray();

        return $this->view('regions.create')
            ->withCountries($countries);
    }

    public function edit($id)
    {
        $region = $this->repository->findOrFail($id);
        $countries = $this->countryRepository->getAll();

        return $this->view('regions.edit')
            ->withRegion($region)
            ->withCountries($countries);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['image_map'] = $request->file('image_map');
            $data['image_banner'] = $request->file('image_banner');
            $data['user'] = cmsUser();

            $region = $this->service->create($data);

            Flash::success("Região {$region->getName()} criada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $region->getId());

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

            $region = $this->service->update($data, $id);

            Flash::success("Região {$region->getName()} atualizada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $region->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $region = $this->repository->find($id);

        try {

            $this->repository->delete($region);

            Flash::success("Região {$region->getName()} excluída com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function removeImage($regionId, $imageId)
    {
        try {

            $region = $this->repository->find($regionId);
            $image = $this->imageRepository->find($imageId);

            $this->service->removeImage($image, $region);

            Flash::success("Imagem excluída com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$regionId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    protected function getCountriesSelectArray()
    {
        $countries = $this->countryRepository->getAll();
        return html_select_array($countries, 'id', 'name');
    }

}