<?php namespace Modules\Prediction;

use Modules\Prediction\Contracts\PredictableManager as IPredictableManager;

class PredictableManager implements IPredictableManager {

    protected $resolvers = [];

    public function __construct($resolvers=[]) {

        foreach($resolvers as $resolver) {
            $this->addResolver($resolver);
        }

    }

    public function addResolver(PredictableResolver $resolver) {
        $this->resolvers[$resolver->getName()] = $resolver;
    }

    /**
     * Get resolver by name.
     *
     * @param $name string
     *   Name of the resolver.
     *
     * @return PredictableResolver
     */
    public function getResolver($name) {
        return $this->resolvers[$name];
    }

    /**
     * Get predictable item.
     *
     * @param $name string
     *   The name.
     *
     * @param $id int
     *   The id.
     *
     * @return Predictable
     */
    public function getPredictable($name,$id) {
        $predictable = $this->getResolver($name)->getById($id);
        return $predictable;
    }

    /**
     * Get resolver for the specified predictable.
     *
     * @param Predictable $predictable
     *
     * @return PredictableResolver
     */
    public function matchResolver(Predictable $predictable) {

        foreach($this->resolvers as $resolver) {
            if($resolver->owns($predictable)) {
                return $resolver;
            }
        }

    }

    /**
     * Determine whether a prediction can currently be made on
     * the specified predictable.
     *
     * @param Predictable $predictable
     *   The predictable entity.
     *
     * @return bool
     */
    public function isPredictionAllowed(Predictable $predictable) : bool {
        return $predictable->isPredictionAllowed();
    }

}