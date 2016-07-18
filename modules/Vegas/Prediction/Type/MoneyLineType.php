<?php namespace Modules\Vegas\Prediction\Type;

use Modules\Prediction\PredictionType;
use Modules\Vegas\Prediction\Compatibility\MoneyLineResolver;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Vegas\Prediction\Forms\MoneyLineForm;
use Modules\Prediction\Entities\Prediction as PredictionEntity;
use Modules\Vegas\Entities\MoneyLine as MoneyLineEntity;
use Doctrine\ORM\QueryBuilder;

class MoneyLineType implements PredictionType {

    protected $formBuilder;

    public function __construct(FormBuilder $formBuilder) {
        $this->formBuilder = $formBuilder;
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

    public function getFrontendForm($args) {
        $form = $this->formBuilder->create(MoneyLineForm::class,$args);
        return $form;
    }

    public function makeQuotePredictionFromRequest() {

    }

    /**
     * Determine whether this type owns the specified prediction entity.
     *
     * @param PredictionEntity $prediction
     *   The prediction entity.
     *
     * @return bool
     */
    public function owns(PredictionEntity $prediction) : bool {
        return $prediction instanceof MoneyLineEntity;
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