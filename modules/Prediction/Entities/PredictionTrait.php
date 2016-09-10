<?php namespace Modules\Prediction\Entities;

use Carbon\Carbon;
use Modules\Catalog\Entities\Line;

trait PredictionTrait {

    protected $id;
    protected $line;
    protected $createdAt;
    protected $updatedAt;
    protected $inverseType;

    public function getId() : int {
        return $this->id;
    }

    public function setLine(Line $line) {
        $this->line = $line;
    }

    public function getLine() : Line {
        return $this->line;
    }

    public function getCreatedAt() : Carbon {
        return $this->createdAt;
    }

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt() : Carbon {
        return $this->updatedAt;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function setInverseType(string $inverseType) {
        $this->inverseType = $inverseType;
    }

    public function getInverseType() : string {
        return $this->inverseType;
    }

    abstract public function jsonSerialize();

}