<?php namespace Modules\Vegas\Prediction\Type;

use Modules\Prediction\PredictionType;
use Modules\Vegas\Prediction\Compatibility\MoneyLineResolver;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Vegas\Prediction\Forms\MoneyLineForm;
use Modules\Prediction\Entities\Prediction as PredictionEntity;
use Modules\Vegas\Entities\MoneyLine as MoneyLineEntity;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Contracts\View\Factory as ViewFactoryContract;
use Modules\Prediction\Contracts\Entities\Prediction as PredictionContract;
use Modules\Vegas\Contracts\Entities\MoneyLine as MoneyLineContract;
use Modules\Vegas\Entities\InverseMoneyLine;
use Modules\Sales\Entities\QuoteMoneyLine as QuoteMoneyLineEntity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Modules\Sports\Repositories\TeamRepository;
use Modules\Sports\Repositories\GameRepository;

class MoneyLineType implements PredictionType {

    protected $formBuilder;
    protected $viewFactory;

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
        return 'vegas_money_line';
    }
    
    public function getCompatibilityResolver() {
        return new MoneyLineResolver();
    }

    public function getFrontendTitle() {
        return 'Money Line';
    }

    public function getInlineViewName() : string {
        return 'vegas::prediction.money-line.inline';
    }

    public function getFrontendForm($args) {
        $form = $this->formBuilder->create(MoneyLineForm::class,$args);
        return $form;
    }

    /**
     * Get the name of the entity class.
     *
     * @return string
     */
    public function getEntityClassName() : string {
        return MoneyLineEntity::class;
    }

    /**
     * Get the name of the inverse entity class.
     *
     * @return string
     */
    public function getInverseEntityClassName() : string {
        return InverseMoneyLine::class;
    }

    public function makeQuotePredictionFromRequest() {

        $prediction = new QuoteMoneyLineEntity();

        $game = $this->gameRepo->findById(Request::get('predictable_id'));
        $team = $this->teamRepo->findById(Request::get('pick'));

        $prediction->setUpdatedAt(Carbon::now());
        $prediction->setCreatedAt(Carbon::now());
        $prediction->setGame($game);
        $prediction->setPick($team);

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
        return $prediction instanceof MoneyLineContract;
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

        $extraJoinConditions = 'l = ';
        $extraJoinConditions.= 'p'.$cursor.'.game = :game'.$cursor;
        $extraJoinConditions.= ' AND p'.$cursor.'.pick = :pick'.$cursor;

        $qb->innerJoin(get_class($prediction),'p'.$cursor,'WITH',$extraJoinConditions);
        //$qb->join(get_class($prediction),'ps'.$cursor,'WITH',$extraJoinConditions);
        //$qb->where('p'.$cursor.' INSTANCE OF '.get_class($prediction));

        /*$qb->where('point_spreads@[p'.$cursor.'].game = :game'.$cursor);
        $qb->where('point_spreads@[p'.$cursor.'].pick = :pick'.$cursor);
        $qb->where('point_spreads@[p'.$cursor.'].spread = :spread'.$cursor);*/

        $qb->setParameter('game'.$cursor,$game);
        $qb->setParameter('pick'.$cursor,$pick);

    }

}