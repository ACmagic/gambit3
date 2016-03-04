<?php namespace Modules\Core\Context;

class ContextResolver {

    protected $resolvers = [];

    public function register(Resolver $resolver) {

        $this->resolvers[$resolver->getName()] = $resolver;

    }

    public function resolve($contextType) {

        foreach($this->resolvers as $resolver) {
            if($resolver->resolves($contextType)) {
                return $resolver->resolve();
            }
        }

    }

}