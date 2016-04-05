<?php

namespace Modules\Football\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Yaml\Dumper;
use Modules\Event\Entities\Competitor;
use Modules\Sports\Entities\Team;
use Modules\Football\Entities\NFLTeam;
use Illuminate\Filesystem\FilesystemManager;

class NFLTeamsFixtureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gambit:football:nfl-teams-fixture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate fixture for NFL football teams.';

    /**
     * The http guzzle client instance.
     */
    protected $client;

    /**
     * File system manager.
     */
    protected $fileSystem;

    /**
     * Collective teams info.
     */
    protected $teamInfo = [];

    /**
     * Yaml hierarchy
     */
    protected $yamlArray = [];

    public function __construct(FilesystemManager $fileSystem) {

        parent::__construct();

        $this->client = new Client(['base_uri' => 'http://www.nfl.com/']);
        $this->fileSystem = $fileSystem;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        // Fetch page with teams.
        $response = $this->client->request('GET', 'teams');

        if($response->getStatusCode() != 200) {
            $this->error('Unable to fetch teams page.');
            return;
        }

        $body = (string) $response->getBody();
        $crawler = new Crawler($body);

        $closure = function(Crawler $node) {
            $this->fetchTeamInfo($node->attr('href'));
        };
        $closure->bindTo($this);
        $crawler->filter('.teamslandinggridgroup .team-site-link + .title a')->each($closure);

        // Create Yaml file
        $this->buildYamlArray();

        $dumper = new Dumper();
        $yaml = $dumper->dump($this->yamlArray,5);
        
        $this->fileSystem->disk('modules')->put('football/nfl_football_teams.yml',$yaml);

        $this->line('NFL Team File Written');

    }

    protected function fetchTeamInfo($profileHref) {

        // Fetch the individual team page.
        $response = $this->client->get($profileHref);

        if($response->getStatusCode() != 200) {
            $this->error('Unable to fetch team info for '.$profileHref);
            return;
        }

        $body = (string) $response->getBody();
        $crawler = new Crawler($body);

        // Get page heading.
        $pageHeadingText = $crawler->filter('.article-decorator h1 a')->text();

        // Pieces
        $pageHeadingPieces = explode(' ',$pageHeadingText);

        $teamName = array_pop($pageHeadingPieces);
        $teamLocation = implode(' ',$pageHeadingPieces);

        $teamCode = NULL;

        // Parse out team code from url
        $queryString = parse_url($profileHref,PHP_URL_QUERY);
        $queryStringPieces = explode('&',$queryString);

        foreach($queryStringPieces as $index=>$piece) {
            if(strpos($piece,'team=') === 0) {
                $teamCode = substr($piece,5);
                break;
            }
        }

        $this->teamInfo[] = [
            'location'=> $teamLocation,
            'name'=> $teamName,
            'code'=> $teamCode,
        ];

        $this->line($teamLocation.' | '.$teamName.' | '.$teamCode);

    }

    protected function buildYamlArray() {

        $this->yamlArray['include'] = array();
        $this->yamlArray['include'][] = 'abstract_sports_team.yml';

        //$this->yamlArray[Competitor::class] = [];
        //$this->yamlArray[Team::class] = [];
        $this->yamlArray[NFLTeam::class] = [];

        foreach($this->teamInfo as $teamInfo) {

            $code = strtolower($teamInfo['code']);

            /*$team = array(
                'name'=>
            );*/

            $nflTeam = [
                'name'=> $teamInfo['name'],
                'machineName'=> $code,
            ];

            $this->yamlArray[NFLTeam::class]['nflTeam_'.$code.' (extends abstract_sports_team)'] = $nflTeam;

        }

    }

}
