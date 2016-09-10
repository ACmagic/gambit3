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

class MoneyLineType implements PredictionType {

    protected $formBuilder;
    protected $viewFactory;

    public function __construct(
        FormBuilder $formBuilder,
        ViewFactoryContract $viewFactory
    ) {
        $this->formBuilder = $formBuilder;
        $this->viewFactory = $viewFactory;
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
     * Get the name of the inverse entity class.
     *
     * @return string
     */
    public function getInverseEntityClassName() : string {
        return InverseMoneyLine::class;
    }

    public function makeQuotePredictionFromRequest() {

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

    }

}