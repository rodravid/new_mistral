<?php

namespace Vinci\App\Core\Utils\Queue;

class QueueWorker
{

    public static function isWorkerRunning($queueName)
    {
        return self::listActiveQueueWorkers()->contains($queueName);
    }

    public static function listActiveQueueWorkers()
    {
        exec('ps aux | grep "queue:work"', $response);

        $queues = collect($response)->filter(function($line) {
            return strpos($line, '--queue=') !== false;
        })->transform(function($line) {
            return explode(' ', trim(explode('--queue=', $line)[1]))[0];
        });

        return $queues;
    }

}