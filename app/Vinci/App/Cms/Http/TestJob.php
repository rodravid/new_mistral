<?php

namespace Vinci\App\Cms\Http;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;
use Vinci\App\Core\Jobs\Job;

class TestJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public function handle()
    {
        sleep(3);

        Storage::disk('local')->put(sprintf('/teste/fila_1_%s', microtime()), 'fila1');
    }

    


}