<?php namespace Modules\Prediction\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Modules\Prediction\Facades\PredictableManager;
use Modules\Prediction\Facades\PredictionTypeManager;

class PredictionController extends AbstractBaseController {

    public function getNew($type,$id) {

        $predictable = PredictableManager::getPredictable($type,$id);
        $types = PredictionTypeManager::getTypes($predictable);

        return view('prediction::frontend.prediction.new',['predictable'=>$predictable,'types'=>$types,'predictableType'=>$type]);

    }

    public function getNewConfigure($type,$id,$predictionType) {

        $theType = PredictionTypeManager::getType($predictionType);
        $form = $theType->getFrontendForm([]);

        return view('prediction::frontend.prediction.new.configure',['form'=>$form]);

    }

}