<?php

namespace Modules\Core\Console;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Core\Console\Commands\SeedDatabase;
use Modules\Core\Console\Commands\QueueFakeJob;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Catalog\Console\Commands\ProcessCompletedLines;
use Modules\Catalog\Console\Commands\ProcessClosedLines;
use Modules\Football\Console\Commands\NFLTeamsFixtureCommand;
use Modules\Football\Console\Commands\NFLGamesFixtureCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        SeedDatabase::class,
        QueueFakeJob::class,

        // Catalog
        ProcessCompletedLines::class,
        ProcessClosedLines::class,

        // Football
        NFLTeamsFixtureCommand::class,
        NFLGamesFixtureCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }
}
