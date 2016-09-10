<?php namespace Modules\Prediction\Contracts\Entities;

use Carbon\Carbon;
use Modules\Catalog\Entities\Line;

interface Prediction {
    public function getId() : int;
    public function setLine(Line $line);
    public function getLine();
    public function getCreatedAt() : Carbon;
    public function setCreatedAt(Carbon $createdAt);
    public function getUpdatedAt() : Carbon;
    public function setUpdatedAt(Carbon $updatedAt);
    public function setInverseType(string $inverseType);
    public function getInverseType() : string;
}