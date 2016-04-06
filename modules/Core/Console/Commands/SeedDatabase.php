<?php

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;
use Nelmio\Alice\Fixtures;
use Modules\Core\Faker\Provider\Helpers;
use Modules\Core\Faker\Provider\Carbon;
use Modules\Core\Faker\Provider\Strings;
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

        $files = [
            database_path('fixtures/base-data/users.yml'),

            // abstract templates (dependent on users)
            database_path('fixtures/base-data/abstract_competitor.yml'),
            database_path('fixtures/base-data/abstract_event.yml'),
            database_path('fixtures/base-data/abstract_sports_team.yml'),
            database_path('fixtures/base-data/abstract_sports_game.yml'),

            // Rest of the stuff.
            database_path('fixtures/base-data/sites.yml'),
            database_path('fixtures/base-data/stores.yml'),
            database_path('fixtures/base-data/sides.yml'),
            database_path('fixtures/base-data/customer_pool.yml'),

            database_path('fixtures/test-data-1/customers.yml'),

            database_path('fixtures/base-data/nfl_football_teams.yml'),
            database_path('fixtures/test-data-1/nfl_football_games.yml'),
        ];

        $generator = new Generator();
        $providers = [
            new Helpers($generator),
            new Carbon($generator),
            new Strings($generator),
        ];

        $objects = Fixtures::load($files, $this->em,[
            'providers'=> $providers
        ]);

    }
}
