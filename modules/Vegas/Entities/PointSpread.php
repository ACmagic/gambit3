<?php namespace Modules\Vegas\Entities;

use Modules\Prediction\Entities\Prediction;
use Modules\Sports\Entities\Team;
use Modules\Vegas\Contracts\Entities\PointSpread as PointSpreadContract;

class PointSpread extends Prediction implements PointSpreadContract {

    use PointSpreadTrait;

}