<?php
namespace Vinci\App\Cms\Http\Integration;

use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\Order\Order;

class IntegrationController extends Controller
{
    public function setAsIntegrated($entityPath, $id)
    {
        try {

            $entity = $this->entityManager->getReference($entityPath, $id);
            $entity->changeErpIntegrationStatus(IntegrationStatus::INTEGRATED);

            if ($entity instanceof Order) {
                $this->changeItemsIntegraionStatus($entity);
            }

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            return Redirect::back();

        } catch (Exception $e) {

        }
    }

    private function changeItemsIntegraionStatus($order)
    {
        foreach ($order->getItems() as $item) {
            $item->changeErpIntegrationStatus(IntegrationStatus::INTEGRATED);
        }
    }
}