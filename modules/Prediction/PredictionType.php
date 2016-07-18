<?php namespace Modules\Prediction;

use Kris\LaravelFormBuilder\Form;
use Modules\Prediction\Entities\Prediction as PredictionEntity;
use Doctrine\ORM\QueryBuilder;

interface PredictionType {

    public function getName();
    
    public function getFrontendTitle();

    /**
     * Get the frontend data entry form.
     *
     * @param array $args
     *
     * @return Form
     */
    public function getFrontendForm($args);

    /**
     * @return CompatibilityResolver
     */
    public function getCompatibilityResolver();

    /**
     * Make prediction for adding to a sales quote.
     */
    public function makeQuotePredictionFromRequest();

    /**
     * Determine whether this type owns the specified prediction entity.
     *
     * @param PredictionEntity $prediction
     *   The prediction entity.
     *
     * @return bool
     */
    public function owns(PredictionEntity $prediction) : bool;

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
    public function requirePredictionWithLine(QueryBuilder $qb,PredictionEntity $prediction,int $cursor=0);

}