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
use Modules\Prediction\Entities\Prediction as PredictionEntity;
use Modules\Vegas\Entities\PointSpread as PointSpreadEntity;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Contracts\View\Factory as ViewFactoryContract;
use Modules\Prediction\Contracts\Entities\Prediction as PredictionContract;
use Modules\Vegas\Contracts\Entities\PointSpread as PointSpreadContract;
use Modules\Vegas\Entities\InversePointSpread;

class PointSpreadType implements PredictionType {

    protected $viewFactory;
    protected $formBuilder;
    protected $teamRepo;
    protected $gameRepo;

    public function __construct(
        FormBuilder $formBuilder,
        ViewFactoryContract $viewFactory
    ) {
        $this->formBuilder = $formBuilder;
        $this->viewFactory = $viewFactory;
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

    public function getInlineViewName() : string {
        return 'vegas::prediction.point-spread.inline';
    }

    /**
     * Get the name of the inverse entity class.
     *
     * @return string
     */
    public function getInverseEntityClassName() : string {
        return InversePointSpread::class;
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

    /**
     * Determine whether this type owns the specified prediction entity.
     *
     * @param PredictionContract $prediction
     *   The prediction entity.
     *
     * @return bool
     */
    public function owns(PredictionContract $prediction) : bool {
        return $prediction instanceof PointSpreadContract;
    }

    /**
     * Include the prediction with the line.
     *
     * @param QueryBuilder $qb
     *   The query builder.
     *
     * @param PredictionEntity $prediction
     *   The prediction entity.
     *
     * @param int $cursor
     *   The prediction cursor to generate unique aliases and placeholders.
     */
    public function requirePredictionWithLine(QueryBuilder $qb,PredictionEntity $prediction,int $cursor=0) {

        $game = $prediction->getGame();
        $pick = $prediction->getPick();
        $spread = $prediction->getSpread();

        $extraJoinConditions = 'l = ';
        $extraJoinConditions.= 'p'.$cursor.'.game = :game'.$cursor;
        $extraJoinConditions.= ' AND p'.$cursor.'.pick = :pick'.$cursor;
        $extraJoinConditions.= ' AND p'.$cursor.'.spread = :spread'.$cursor;

        $qb->innerJoin(get_class($prediction),'p'.$cursor,'WITH',$extraJoinConditions);
        //$qb->join(get_class($prediction),'ps'.$cursor,'WITH',$extraJoinConditions);
        //$qb->where('p'.$cursor.' INSTANCE OF '.get_class($prediction));

        /*$qb->where('point_spreads@[p'.$cursor.'].game = :game'.$cursor);
        $qb->where('point_spreads@[p'.$cursor.'].pick = :pick'.$cursor);
        $qb->where('point_spreads@[p'.$cursor.'].spread = :spread'.$cursor);*/

        $qb->setParameter('game'.$cursor,$game);
        $qb->setParameter('pick'.$cursor,$pick);
        $qb->setParameter('spread'.$cursor,$spread);

    }
    
}