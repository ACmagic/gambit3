<?php namespace Modules\Vegas\Entities;

use Modules\Prediction\Entities\Prediction;
use Modules\Vegas\Contracts\Entities\MoneyLine as MoneyLineContract;

class MoneyLine extends Prediction implements MoneyLineContract {

    use MoneyLineTrait;

}