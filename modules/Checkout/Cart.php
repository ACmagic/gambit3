<?php namespace Modules\Checkout;

use Modules\Core\Context\Context;
use Modules\Checkout\Contracts\Context\Cart as CartContract;
use Modules\Sales\Entities\Quote as QuoteEntity;
use Modules\Sales\Entities\QuotePrediction as QuotePredictionEntity;
use Modules\Sales\Entities\QuoteAdvertisedLine as QuoteAdvertisedLineEntity;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Modules\Catalog\Repositories\SideRepository;

class Cart implements Context, CartContract {

    protected $quote;
    protected $em;
    
    protected $sideRepo;

    public function __construct(
        QuoteEntity $quote,
        EntityManagerInterface $em,
        SideRepository $sideRepo
    ) {
        $this->quote = $quote;
        $this->em = $em;
        $this->sideRepo = $sideRepo;
    }

    public function getName() {
        return 'cart';
    }

    public function getQuote() {
        return $this->quote;
    }

    public function addPrediction(QuotePredictionEntity $prediction) {

        $item = $this->quote->getFirstAdvertisedLineItem();
        if(!$item) {
            $item = $this->makeAdvertisedLineItem();
            $prediction->setAdvertisedLine($item);
            $this->quote->addItem($item);
        } else {
            $prediction->setAdvertisedLine($item);
        }

        $item->addPrediction($prediction);

        $this->em->persist($this->quote);
        $this->em->flush();

    }

    protected function makeAdvertisedLineItem() {

        // Default side
        $house = $this->sideRepo->getHouse();

        $item = new QuoteAdvertisedLineEntity();
        $item->setSide($house);
        $item->setQuote($this->quote);
        $item->setOdds(0);
        $item->setInventory(0);
        $item->setAmount(0.00);
        $item->setCreatedAt(Carbon::now());
        $item->setUpdatedAt(Carbon::now());

        return $item;

    }

}