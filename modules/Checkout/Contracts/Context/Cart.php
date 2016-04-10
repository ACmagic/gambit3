<?php namespace Modules\Checkout\Contracts\Context;

use Modules\Sales\Entities\Quote as QuoteEntity;
use Modules\Sales\Entities\QuotePrediction as QuotePredictionEntity;

interface Cart {

    /**
     * Get sales quote.
     *
     * @return QuoteEntity
     */
    public function getQuote();

    /**
     * Add prediction to quote.
     *
     * @param QuotePredictionEntity $prediction
     */
    public function addPrediction(QuotePredictionEntity $prediction);

}