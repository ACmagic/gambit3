<?php namespace Modules\Prediction;

interface Predictable {
    public function getId();
    public function isPredictionAllowed(): bool;
}