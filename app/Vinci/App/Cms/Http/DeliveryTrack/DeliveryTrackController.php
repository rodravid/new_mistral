<?php

namespace Vinci\App\Cms\Http\DeliveryTrack;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\DeliveryTrack\DeliveryTrack;
use Vinci\Domain\DeliveryTrack\DeliveryTrackRepository;
use Vinci\Domain\DeliveryTrack\DeliveryTrackService;
use Vinci\Domain\DeliveryTrack\LineFactory;
use Vinci\Infrastructure\DeliveryTrack\Datatables\DeliveryTrackCmsDatatable;

class DeliveryTrackController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = DeliveryTrackCmsDatatable::class;

    protected $lineFactory;

    public function __construct(
        EntityManagerInterface $em,
        DeliveryTrackService $service,
        DeliveryTrackRepository $repository,
        LineFactory $lineFactory
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->lineFactory = $lineFactory;
    }

    public function index()
    {
        return $this->view('delivery_tracks.list');
    }

    public function create(Request $request)
    {
        $lines = $this->getDeliveryTrackLines($request);

        return $this->view('delivery_tracks.create')
            ->withLines($lines);
    }

    public function edit(Request $request, $id)
    {
        $deliveryTrack = $this->repository->findOrFail($id);

        $lines = $this->getDeliveryTrackLines($request, $deliveryTrack);

        return $this->view('delivery_tracks.edit', compact('deliveryTrack', 'lines'));
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['user'] = cmsUser();

            $deliveryTrack = $this->service->create($data);

            Flash::success("Faixa de CEP criada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $deliveryTrack->getId());

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
            $data['user'] = cmsUser();

            $deliveryTrack = $this->service->update($data, $id);

            Flash::success("Faixa de CEP atualizada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $deliveryTrack->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $deliveryTrack = $this->repository->find($id);

        try {

            $this->repository->delete($deliveryTrack);

            Flash::success("Faixa de CEP excluída com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    protected function getDeliveryTrackLines(Request $request, DeliveryTrack $deliveryTrack = null)
    {
        if ($request->old('line')) {
            return $this->lineFactory->makeCollectionFromArray($request->old('line'));
        }

        if ($deliveryTrack) {
            return $deliveryTrack->getLines();
        }
    }

}