<?php namespace Modules\Vegas\Prediction\Compatibility;

use Modules\Prediction\CompatibilityResolver;
use Modules\Prediction\CompatibilityResolverTrait;
use Modules\Sports\Entities\Game;

class MoneyLineResolver implements CompatibilityResolver {

    use CompatibilityResolverTrait;

    public function isCompatible() {
        return $this->predictable instanceof Game;
    }

}