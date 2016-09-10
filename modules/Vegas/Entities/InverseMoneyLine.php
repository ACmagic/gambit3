<?php namespace Modules\Vegas\Entities;

use Modules\Prediction\Entities\InversePrediction;
use Modules\Vegas\Contracts\Entities\MoneyLine as MoneyLineContract;

class InverseMoneyLine extends InversePrediction implements MoneyLineContract {

    use MoneyLineTrait;

}