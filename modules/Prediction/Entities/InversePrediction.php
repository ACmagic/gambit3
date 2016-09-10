<?php namespace Modules\Prediction\Entities;

use Modules\Prediction\Contracts\Entities\Prediction as PredictionContract;

abstract class InversePrediction implements \JsonSerializable, PredictionContract {

    use PredictionTrait;

}