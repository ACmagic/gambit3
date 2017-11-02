<?php

namespace Modules\Catalog\Console\Commands;

use Illuminate\Console\Command;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Jobs\PaybackLine;

/**
 * @todo: I don't really think this module is the most appropriate location but it will do for now.
 */
class ProcessClosedLines extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gambit:catalog:process-closed-lines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process/queue up closed lines for pay backs.';

    /**
     * @var LineRepository
     */
    protected $lineRepo;

    public function __construct(LineRepository $lineRepo) {

        parent::__construct();

        $this->lineRepo = $lineRepo;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $ids = $this->lineRepo->findIdsOfClosedLines();
        foreach($ids as $id) {
            $job = (new PaybackLine($id))->delay(10);
            dispatch($job);
            $this->line('Queued line '.$id);
        }

    }

}