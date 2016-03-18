<?php namespace Modules\Prediction\Entities;

use Modules\Catalog\Entities\Line;

class Prediction {

    protected $id;
    protected $line;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function setLine(Line $line) {
        $this->line = $line;
    }

    public function getLine() {
        return $this->line;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}