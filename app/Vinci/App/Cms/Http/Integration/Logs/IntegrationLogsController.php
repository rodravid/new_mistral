<?php

namespace Vinci\App\Cms\Http\Integration\Logs;

use Vinci\App\Cms\Http\Controller;
use Vinci\App\Integration\ERP\Logger\IntegrationLogger;

class IntegrationLogsController extends Controller
{
    
    public function show($type, $id)
    {
        $log = IntegrationLogger::type($type)->getOneById($id);

        return $this->view(sprintf('integration.logs.types.%s', $type), compact('log'));
    }

}