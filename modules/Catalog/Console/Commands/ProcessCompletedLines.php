<?php

namespace Modules\Catalog\Console\Commands;

use Illuminate\Console\Command;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Jobs\PayoutLine;

/**
 * @todo: I don't really think this module is the most appropriate location but it will do for now.
 */
class ProcessCompletedLines extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gambit:catalog:process-completed-lines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process/queue up completed lines for payouts.';

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

        $ids = $this->lineRepo->findIdsOfCompletedLines();
        foreach($ids as $id) {
            $job = (new PayoutLine($id))->delay(10);
            dispatch($job);
        }

    }

}