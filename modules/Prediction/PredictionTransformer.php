<?php namespace Modules\Prediction;

use League\Fractal\TransformerAbstract;

class PredictionTransformer extends TransformerAbstract {

    public function transform(PredictionType $predictionType) {
        return [
            'name'=> $predictionType->getName(),
            'frontendTitle'=> $predictionType->getFrontendTitle()
        ];
    }

}