<?php

namespace Vinci\App\Cms\Http\Promotion\ShippingPromotion;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\DeliveryTrack\DeliveryTrackRepository;
use Vinci\Domain\Promotion\Types\Shipping\ShippingPromotionRepository;
use Vinci\Domain\Promotion\Types\Shipping\ShippingPromotionService;
use Vinci\Infrastructure\Promotion\Types\Shipping\Datatables\ShippingPromotionCmsDatatable;

class ShippingPromotionController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    private $deliveryTrackRepository;

    protected $datatable = ShippingPromotionCmsDatatable::class;

    public function __construct(
        EntityManagerInterface $em,
        ShippingPromotionService $service,
        ShippingPromotionRepository $repository,
        DeliveryTrackRepository $deliveryTrackRepository
    ) {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->deliveryTrackRepository = $deliveryTrackRepository;
    }

    public function index()
    {
        return $this->view('promotions.shipping.list');
    }

    public function create()
    {
        $deliveryTracks = $this->getDeliveryTracks();

        return $this->view('promotions.shipping.create', compact('deliveryTracks'));
    }

    public function edit($id)
    {
        $promotion = $this->repository->findOrFail($id);

        $deliveryTracks = $this->getDeliveryTracks();

        $selectedDeliveryTracks = [];

        foreach ($promotion->getDeliveryTracks() as $track) {
            $selectedDeliveryTracks[] = $track->getId();
        }

        return $this->view('promotions.shipping.edit', compact('promotion', 'deliveryTracks', 'selectedDeliveryTracks'));
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $promotion = $this->service->create(array_merge($data, ['user' => $this->user]));

            Flash::success("Promoção {$promotion->getTitle()} criada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $promotion->getId());

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

            $promotion = $this->service->update($data, $id);

            Flash::success("Promoção {$promotion->getTitle()} atualizada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $promotion->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $promotion = $this->repository->find($id);

        try {

            $this->repository->delete($promotion);

            Flash::success("Promoção {$promotion->getTitle()} excluída com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    private function getDeliveryTracks()
    {
        $deliveryTracks = $this->deliveryTrackRepository->getAll();

        return html_select_array($deliveryTracks);
    }

}