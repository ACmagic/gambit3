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

    /**
     * Replace current quote with specified quote.
     *
     * @param QuoteEntity $quote
     *   The quote entity.
     */
    public function replaceQuote(QuoteEntity $quote);

    /**
     * Restore a replaced quote.
     */
    public function restoreQuote();

}