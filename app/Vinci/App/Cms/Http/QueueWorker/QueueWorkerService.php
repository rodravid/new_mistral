<?php

namespace Vinci\App\Cms\Http\QueueWorker;

use GuzzleHttp\Client;
use Vinci\App\Cms\Http\Controller;

class QueueWorkerService extends Controller
{

    protected $availableWorkers = [
        [
            'name' => 'vinci-elasticsearch-products',
            'description' => 'Fila de sincronização de produtos com elasticsearch.'
        ],
        [
            'name' => 'vinci-integration-customers,vinci-integration-orders',
            'description' => 'Fila de integração de clientes com ERP.'
        ],
        [
            'name' => 'vinci-integration-customers,vinci-integration-orders',
            'description' => 'Fila de integração de pedidos com ERP.'
        ],
        [
            'name' => 'vinci-email-orders',
            'description' => 'Fila de envio de e-mail de confirmação de pedido.'
        ],
        [
            'name' => 'vinci-email-customers',
            'description' => 'Fila de envio de e-mail de confirmação de cadastro.'
        ]
    ];

    protected $cronUrl = 'http://cron.vinci.com.br';

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

        $url = $this->cronUrl . '/cms/queue-worker/getQueueWorkerStatus';

        $response = $http->get($url, [
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
        return collect($this->availableWorkers);
    }

}