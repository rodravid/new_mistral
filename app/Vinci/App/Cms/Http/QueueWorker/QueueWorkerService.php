<?php

namespace Vinci\App\Cms\Http\QueueWorker;

use GuzzleHttp\Client;
use Vinci\App\Cms\Http\Controller;

class QueueWorkerService extends Controller
{
    public function getQueueWorkersStatus()
    {
        $activeWorkers = $this->listActiveQueueWorkers();

        return $this->getAvailableWorkers()->transform(function($worker) use ($activeWorkers) {

            $active = $activeWorkers->contains($worker['name']);

            return [
                'name' => $worker['name'],
                'description' => $worker['description'],
                'active' => $active
            ];

        });
    }

    public function getQueueWorkersStatusCron()
    {
        $http = new Client;

        $response = $http->get($this->getCronServiceUrl(), [
            'auth' => ['webeleven', 'w11homolog']
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function isWorkerRunning($queueName)
    {
        return $this->listActiveQueueWorkers()->contains($queueName);
    }

    public function listActiveQueueWorkers()
    {
        exec('ps aux | grep "queue:work"', $response);

        $queues = collect($response)->filter(function($line) {
            return strpos($line, '--queue=') !== false;
        })->transform(function($line) {
            return explode(' ', trim(explode('--queue=', $line)[1]))[0];
        });

        return $queues;
    }

    public function getAvailableWorkers()
    {
        return collect([
            [
                'name' => env('QUEUE_PRODUCTS_ELASTICSEARCH'),
                'description' => 'Fila de sincronização de produtos com elasticsearch.'
            ],
            [
                'name' => env('QUEUE_CUSTOMERS_INTEGRATION') . ',' . env('QUEUE_ORDERS_INTEGRATION'),
                'description' => 'Fila de integração de clientes com ERP.'
            ],
            [
                'name' => env('QUEUE_CUSTOMERS_INTEGRATION') . ',' . env('QUEUE_ORDERS_INTEGRATION'),
                'description' => 'Fila de integração de pedidos com ERP.'
            ],
            [
                'name' => env('QUEUE_ORDERS_EMAILS'),
                'description' => 'Fila de envio de e-mail de confirmação de pedido.'
            ],
            [
                'name' => env('QUEUE_CUSTOMERS_EMAILS'),
                'description' => 'Fila de envio de e-mail de confirmação de cadastro.'
            ]
        ]);
    }

    public function getCronServiceUrl()
    {
        return sprintf('%s/cms/queue-worker/getQueueWorkerStatus', env('CRON_URL'));
    }

}