<?php

namespace Vinci\Domain\ERP\Customer\Events\Listeners;

use Vinci\Domain\ERP\Customer\Events\CustomerSaveOnErpFailed;
use Vinci\Domain\ERP\Customer\Events\CustomerWasSavedOnErp;

class CustomerEventSubscriber
{
    
    public function onCustomerSavedOnErp(CustomerWasSavedOnErp $event)
    {
        //@TODO Log de sucesso
    }

    public function onCustomerSaveFailed(CustomerSaveOnErpFailed $event)
    {
        //@TODO Log de erro
    }

    public function subscribe($events)
    {
        $events->listen(
            'Vinci\Domain\ERP\Customer\Events\CustomerWasSavedOnErp',
            'Vinci\Domain\ERP\Customer\Events\Listeners\CustomerEventSubscriber@onCustomerSavedOnErp'
        );

        $events->listen(
            'Vinci\Domain\ERP\Customer\Events\CustomerSaveOnErpFailed',
            'Vinci\Domain\ERP\Customer\Events\Listeners\CustomerEventSubscriber@onCustomerSaveFailed'
        );
    }

}