<?php namespace Modules\Vegas\Prediction\Type;

use Modules\Prediction\PredictionType;
use Modules\Vegas\Prediction\Compatibility\PointSpreadResolver;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Vegas\Prediction\Forms\PointSpreadForm;
use Modules\Sales\Entities\QuotePointSpread as QuotePointSpreadEntity;
use Illuminate\Support\Facades\Request;
use Modules\Sports\Repositories\TeamRepository;
use Modules\Sports\Repositories\GameRepository;
use Carbon\Carbon;

class PointSpreadType implements PredictionType {

    protected $formBuilder;
    protected $teamRepo;
    protected $gameRepo;

    public function __construct(FormBuilder $formBuilder) {
        $this->formBuilder = $formBuilder;
    }

    public function injectGameRepo(GameRepository $gameRepo) {
        $this->gameRepo = $gameRepo;
    }

    public function injectTeamRepo(TeamRepository $teamRepo) {
        $this->teamRepo = $teamRepo;
    }

    public function getName() {
        return 'vegas_point_spread';
    }

    public function getCompatibilityResolver() {
        return new PointSpreadResolver();
    }

    public function getFrontendTitle() {
        return 'Point Spread';
    }

    public function getFrontendForm($args) {
        $form = $this->formBuilder->create(PointSpreadForm::class,$args);
        return $form;
    }
    
    public function makeQuotePredictionFromRequest() {

        $prediction = new QuotePointSpreadEntity();

        $game = $this->gameRepo->findById(Request::get('predictable_id'));
        $team = $this->teamRepo->findById(Request::get('pick'));
        $spread = Request::get('spread');

        $prediction->setUpdatedAt(Carbon::now());
        $prediction->setCreatedAt(Carbon::now());
        $prediction->setGame($game);
        $prediction->setPick($team);
        $prediction->setSpread($spread);

        return $prediction;

    }
    
}