<?php namespace Modules\Core\Context;

class ContextManager {

    protected $resolver;
    protected $activeContexts = [];

    public function __construct(ContextResolver $resolver) {
        $this->resolver = $resolver;
    }

    public function getActiveContext($name) {

        if(!isset($this->activeContexts[$name])) {
            $this->activeContexts[$name] = $this->resolver->resolve($name);
        }

        return $this->activeContexts[$name];
    }

}