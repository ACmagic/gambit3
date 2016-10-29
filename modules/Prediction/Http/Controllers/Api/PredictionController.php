<?php namespace Modules\Prediction\Http\Controllers\Api;

use Modules\Core\Http\Controllers\Api\AbstractBaseController;
use Modules\Prediction\Facades\PredictableManager;
use Modules\Prediction\Facades\PredictionTypeManager;
use Illuminate\Http\Request;
use Modules\Checkout\Facades\Cart;

class PredictionController extends AbstractBaseController {

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
        ];
        $form = $theType->getFrontendForm($args);

        return response()->json($form);

    }

}