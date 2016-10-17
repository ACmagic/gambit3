<?php

namespace Modules\Football\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Yaml\Dumper;
use Modules\Football\Entities\NFLGame;
use Illuminate\Filesystem\FilesystemManager;
use Carbon\Carbon;
use Modules\Football\Repositories\NFLTeamRepository;

class NFLGamesFixtureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gambit:football:nfl-games-fixture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate fixture for NFL football games.';

    /**
     * The http guzzle client instance.
     */
    protected $client;

    /**
     * File system manager.
     */
    protected $fileSystem;

    /**
     * The NFL team repo.
     */
    protected $nflTeamRepo;

    /**
     * Collective Games data.
     */
    protected $gamesData = [];

    /**
     * Current game date.
     */
    protected $currentDate;

    /**
     * Yaml build array.
     */
    protected $yamlArray = [];

    public function __construct(FilesystemManager $fileSystem,NFLTeamRepository $nflTeamRepo) {

        parent::__construct();

        $this->client = new Client(['base_uri' => 'http://www.nfl.com/']);
        $this->fileSystem = $fileSystem;
        $this->nflTeamRepo = $nflTeamRepo;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        // Fetch full season schedule.
        $this->fetchSchedule(2015);

        // Build yaml file
        $this->buildYamlArray();

        // Write to file.
        $dumper = new Dumper();
        $yaml = $dumper->dump($this->yamlArray,5);

        $this->fileSystem->disk('modules')->put('football/nfl_football_games.yml',$yaml);

        $this->line('NFL Game File Written');

    }

    protected function fetchSchedule($year) {

        $weeks = range(1,17);

        foreach($weeks as $week) {

            $uri = '/schedules/'.$year.'/REG'.$week;

            $response = $this->client->request('GET',$uri);
            if($response->getStatusCode() != 200) {
                $this->error('Error fetching '.$uri);
                continue;
            }

            $body = (string) $response->getBody();
            $crawler = new Crawler($body);

            $closure = function(Crawler $node) use ($year) {
                $this->parseScheduleItem($node,$year);
            };
            $closure->bindTo($this);
            $crawler->filter('.schedules-list-date,.schedules-list-matchup')->each($closure);

        }

    }

    protected function parseScheduleItem(Crawler $node, $year) {

        $classes = explode(' ',$node->attr('class'));

        if(in_array('schedules-list-date',$classes)) {

            $dateText = $node->filter('span > span')->text();
            $commaIndex = strpos($dateText,', ') + 2;
            $dateText = substr($dateText,$commaIndex).' '.$year;

            $dt = Carbon::parse($dateText);
            $this->currentDate = $dt;

        } else if(in_array('schedules-list-matchup',$classes)) {

            $awayText = $node->filter('.team-name.away')->text();
            $homeText = $node->filter('.team-name.home')->text();

            try {
                $awayTeam = $this->nflTeamRepo->findByName($awayText);
                $homeTeam = $this->nflTeamRepo->findByName($homeText);
            } catch(\Exception $e) {
                $this->error('Unable to match football team '.$awayText.' or '.$homeText);
                return;
            }

            if(!$awayTeam || !$homeTeam) {
                $this->error('Unable to match football team '.$awayText.' or '.$homeText);
                return;
            }

            $this->gamesData[] = [
                'startsAt'=> '<carbon_parse("'.$this->currentDate->toDateTimeString().'")>',
                'homeTeam'=> '@nflTeam_'.$homeTeam->getMachineName(),
                'awayTeam'=> '@nflTeam_'.$awayTeam->getMachineName(),
                'displayTitle'=> $awayTeam->getName().' @ '.$homeTeam->getName(),
                'year'=> $year,
            ];

        }

    }

    protected function buildYamlArray() {

        $this->yamlArray[NFLGame::class] = [];

        foreach($this->gamesData as $index=>$gameData) {

            $nflGame = [
                'startsAt'=> $gameData['startsAt'],
                'homeTeam'=> $gameData['homeTeam'],
                'awayTeam'=> $gameData['awayTeam'],
                'displayTitle'=> $gameData['displayTitle'],

                // These will all go into the nfl category.
                'categories'=> ['@category_nfl'],

                // Default state to pending
                'state'=> '@event_workflow_state_pending',
            ];

            $this->yamlArray[NFLGame::class]['nflGame_'.$gameData['year'].'_'.$index.' (extends abstract_sports_game)'] = $nflGame;

        }

    }

}
