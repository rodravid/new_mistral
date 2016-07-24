<?php

namespace Vinci\App\Integration\ERP\Logger;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class IntegrationLogPresenter extends AbstractPresenter
{

    public function presentCreatedAt()
    {
        return $this->toDefaultDateTime($this->getObject()->created_at);
    }

    public function presentStatusHtml()
    {
        switch ($this->getObject()->type) {
            case 'success':
                return '<span class="text-success"><i class="fa fa-check"></i> Sucesso</span>';
                break;
            case 'error':
                return '<span class="text-danger"><i class="fa fa-exclamation-circle"></i> Erro</span>';
                break;
        }
    }

}