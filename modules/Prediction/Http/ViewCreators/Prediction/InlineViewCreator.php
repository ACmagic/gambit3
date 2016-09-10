<?php

namespace Modules\Prediction\Http\ViewCreators\Prediction;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\View;
use Modules\Prediction\Contracts\PredictionTypeManager;

/*
 * The view file prediction::prediction.inline is dynamically resolved based on the prediction type.
 */
class InlineViewCreator {

    protected $predictionTypeManager;

    public function __construct(
        PredictionTypeManager $predictionTypeManager
    ) {
        $this->predictionTypeManager = $predictionTypeManager;
    }

    public function create(ViewContract $view) {

        if($view instanceof View) {

            $prediction = $view->prediction;
            $type = $this->predictionTypeManager->getTypeByEntity($prediction);
            $viewName = $type->getInlineViewName($prediction);
            $path = $view->getFactory()->getFinder()->find($viewName);
            $view->setPath($path);

        }

    }

}