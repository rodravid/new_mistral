<?php

namespace Vinci\App\Cms\Http;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vinci\App\Core\Jobs\Job;

class TestJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public function handle()
    {

        throw new \Exception;

    }

    


}