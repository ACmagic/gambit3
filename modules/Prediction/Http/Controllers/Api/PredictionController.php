<?php namespace Modules\Prediction\Http\Controllers\Api;

use Modules\Core\Http\Controllers\Api\AbstractBaseController;
use Modules\Prediction\Facades\PredictableManager;
use Modules\Prediction\Facades\PredictionTypeManager;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Modules\Core\Forms\Transformers\FormTransformer;
use Modules\Prediction\PredictionTransformer;

class PredictionController extends AbstractBaseController {

    /**
     * FractalManager
     */
    protected $fractal;

    public function __construct(FractalManager $fractal) {
        $this->fractal = $fractal;
    }

    public function getNew($type,$id) {

        $predictable = PredictableManager::getPredictable($type,$id);
        $types = PredictionTypeManager::getTypes($predictable);

        if(!PredictableManager::isPredictionAllowed($predictable)) {
            abort(403,'Betting not allowed for specified event.');
        }

        $resource = new Collection($types,new PredictionTransformer);

        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);

    }

    public function getNewConfigure($type,$id,$predictionType) {

        $theType = PredictionTypeManager::getType($predictionType);
        $predictable = PredictableManager::getPredictable($type,$id);
        $resolver = PredictableManager::matchResolver($predictable);

        if(!PredictableManager::isPredictionAllowed($predictable)) {
            abort(403,'Betting not allowed for specified event.');
        }

        $args = [
            'predictable'=> $predictable,
            'predictable_resolver'=> $resolver,
            'prediction_type'=> $theType,
            'method'=> 'POST',
            'route'=> 'prediction.add',

            // Displaying errors requires session
            'errors_enabled'=> false
        ];
        $form = $theType->getFrontendForm($args);
        $resource = new Item($form,new FormTransformer());

        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);

    }

}