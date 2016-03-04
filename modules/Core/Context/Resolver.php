<?php namespace Modules\Core\Context;

interface Resolver {

    public function getName();
    public function resolves($contextType);
    public function resolve();

}