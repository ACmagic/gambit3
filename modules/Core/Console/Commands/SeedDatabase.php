<?php

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;
use Nelmio\Alice\Fixtures;
use Modules\Core\Faker\Provider\Helpers;
use Modules\Core\Faker\Provider\Carbon;
use Faker\Generator;
use Doctrine\ORM\EntityManagerInterface;

class SeedDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gambit:core:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the gambit database.';

    protected $em;

    public function __construct(EntityManagerInterface $em) {

        parent::__construct();

        $this->em = $em;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $file = database_path('fixtures/base-data/users.yml');

        $generator = new Generator();
        $providers = [
            new Helpers($generator),
            new Carbon($generator),
        ];

        $objects = Fixtures::load($file, $this->em,[
            'providers'=> $providers
        ]);
        
    }
}
