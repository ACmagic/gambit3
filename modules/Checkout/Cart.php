<?php namespace Modules\Checkout;

use Modules\Core\Context\Context;
use Modules\Checkout\Contracts\Context\Cart as CartContract;
use Modules\Sales\Entities\Quote as QuoteEntity;
use Modules\Sales\Entities\QuotePrediction as QuotePredictionEntity;
use Modules\Sales\Entities\QuoteAdvertisedLine as QuoteAdvertisedLineEntity;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Modules\Catalog\Repositories\SideRepository;
use Illuminate\Session\SessionManager;
use Modules\Sales\Repositories\QuoteRepository;

class Cart implements Context, CartContract {

    const

    SESS_KEY_RESTORE_QUOTE_IDS = 'cart.restoreQuoteIds';

    protected $quote;
    protected $em;
    protected $sessionMgr;
    protected $quoteRepo;
    
    protected $sideRepo;

    public function __construct(
        SessionManager $sessionMgr,
        QuoteEntity $quote,
        EntityManagerInterface $em,
        SideRepository $sideRepo,
        QuoteRepository $quoteRepo
    ) {
        $this->sessionMgr = $sessionMgr;
        $this->quote = $quote;
        $this->em = $em;
        $this->sideRepo = $sideRepo;
        $this->quoteRepo = $quoteRepo;
    }

    public function getName() {
        return 'cart';
    }

    public function getQuote() {
        return $this->quote;
    }

    public function replaceQuote(QuoteEntity $quote) {

        /*
         * @todo: In theory this is the wrong way but will work with MySQL.
         */
        $currentQuoteIsManaged = $this->quote->getId() !== NULL;

        if($currentQuoteIsManaged) {

            $quoteId = $this->quote->getId();
            $this->quote->setIsCart(NULL);

            $this->sessionMgr->push(self::SESS_KEY_RESTORE_QUOTE_IDS,$quoteId);
        }

        $quote->setIsCart(true);
        $quote->setIsExpired(false);
        $quote->setExpiredAt(NULL);

        if($currentQuoteIsManaged) {
            $this->em->persist($this->quote);
            $this->em->flush();
        }

        $this->em->persist($quote);
        $this->em->flush();

    }

    public function restoreQuote() {

        if($this->sessionMgr->has(self::SESS_KEY_RESTORE_QUOTE_IDS)) {

            $quoteIds = $this->sessionMgr->get(self::SESS_KEY_RESTORE_QUOTE_IDS);

            $lastKey = count($quoteIds) - 1;
            $quoteId = $this->sessionMgr->pull(self::SESS_KEY_RESTORE_QUOTE_IDS.'.'.$lastKey);

            if($quoteId) {

                $quote = $this->quoteRepo->findById($quoteId);

                if($quote) {

                    $quote->setIsCart(true);
                    $quote->setIsExpired(false);
                    $quote->setExpiredAt(NULL);

                    $this->em->persist($quote);
                    $this->em->flush();

                }

            }

        }

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