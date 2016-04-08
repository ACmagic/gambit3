<?php namespace Modules\Prediction;

use Kris\LaravelFormBuilder\Form;

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

}