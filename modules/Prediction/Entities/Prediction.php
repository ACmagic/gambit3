<?php namespace Modules\Prediction\Entities;

use Carbon\Carbon;
use Modules\Catalog\Entities\Line;

abstract class Prediction implements \JsonSerializable {

    protected $id;
    protected $line;
    protected $createdAt;
    protected $updatedAt;

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

    abstract public function jsonSerialize();

}