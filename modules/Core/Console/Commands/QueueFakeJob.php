<?php

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;
use Modules\Core\Jobs\FakeJob;

class QueueFakeJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gambit:core:queue-fake-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue fake job for debugging laravel internals.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        dispatch(new FakeJob());
        $this->line('Queued fake job.');

    }
}
