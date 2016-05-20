<?php namespace Modules\Catalog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FulfillAdvertisedLine implements ShouldQueue {

    use Queueable;
    use InteractsWithQueue;

    public function __construct() {
    }

    public function handle() {

        echo 'Fulfill Advertised Line!';

    }

}