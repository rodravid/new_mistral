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
                return '<span class="badge bg-green"><i class="fa fa-check"></i> Sucesso</span>';
                break;
            case 'error':
                return '<span class="badge bg-red"><i class="fa fa-exclamation-circle"></i> Falhou</span>';
                break;
        }
    }

    public function presentRequestType()
    {
        switch ($this->getObject()->request_type) {
            case 'get':
                return 'Checagem';
                break;
            case 'update':
                return 'Atualização';
                break;
        }
    }

}