<?php namespace Modules\Prediction\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Modules\Prediction\Facades\PredictableManager;
use Modules\Prediction\Facades\PredictionTypeManager;
use Illuminate\Http\Request;
use Modules\Checkout\Facades\Cart;

class PredictionController extends AbstractBaseController {

    public function getNew($type,$id) {

        $predictable = PredictableManager::getPredictable($type,$id);
        $types = PredictionTypeManager::getTypes($predictable);

        return view('prediction::frontend.prediction.new',['predictable'=>$predictable,'types'=>$types,'predictableType'=>$type]);

    }

    public function getNewConfigure($type,$id,$predictionType) {

        $theType = PredictionTypeManager::getType($predictionType);
        $predictable = PredictableManager::getPredictable($type,$id);
        $resolver = PredictableManager::matchResolver($predictable);

        $args = [
            'predictable'=> $predictable,
            'predictable_resolver'=> $resolver,
            'prediction_type'=> $theType,
            'method'=> 'POST',
            'route'=> 'prediction.add',
        ];
        $form = $theType->getFrontendForm($args);

        return view('prediction::frontend.prediction.new.configure',['form'=>$form]);

    }

    public function postNew(Request $request) {

        $predictionType = $request->get('prediction_name');
        $type = $request->get('predictable_type');
        $id = $request->get('predictable_id');

        $theType = PredictionTypeManager::getType($predictionType);
        $predictable = PredictableManager::getPredictable($type,$id);
        $resolver = PredictableManager::matchResolver($predictable);

        $args = [
            'predictable'=> $predictable,
            'predictable_resolver'=> $resolver,
            'prediction_type'=> $theType,
        ];
        $form = $theType->getFrontendForm($args);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        try {
            $prediction = $theType->makeQuotePredictionFromRequest();
            Cart::addPrediction($prediction);
            return redirect()->route('slip');
        } catch(\Exception $e) {
            $x = 'y';
        }

    }

}