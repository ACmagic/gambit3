<?php namespace Modules\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FakeJob implements ShouldQueue {

    use Queueable;
    use InteractsWithQueue;

    public function __construct() {
    }

    /**
     * Handle the job.
     */
    public function handle() {

        $x = 'y';

    }

}