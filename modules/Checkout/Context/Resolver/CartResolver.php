<?php namespace Modules\Checkout\Context\Resolver;

use Modules\Core\Context\Resolver;
use Modules\Checkout\Cart;
use Modules\Sales\Entities\Quote as QuoteEntity;
use Modules\Sales\Repositories\QuoteRepository;
use Illuminate\Session\SessionManager;
use Modules\Core\Facades\Site;
use Modules\Core\Repositories\SiteRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;

class CartResolver implements Resolver {

    protected $quoteRepository;
    protected $sessionMgr;
    protected $siteRepo;
    protected $em;

    public function __construct(QuoteRepository $quoteRepository,SessionManager $sessionMgr,SiteRepository $siteRepo,EntityManagerInterface $em) {
        $this->quoteRepository = $quoteRepository;
        $this->sessionMgr = $sessionMgr;
        $this->siteRepo = $siteRepo;
        $this->em = $em;
    }

    public function getName() {
        return 'cart_resolver';
    }

    public function resolves($contextType) {
        return $contextType == 'cart';
    }

    public function resolve() {

        $session = $this->sessionMgr->driver();
        $sessionId = $session->getId();
        $siteId = Site::getSiteId();

        $quote = $this->quoteRepository->findBySessionIdAndSiteId($sessionId,$siteId);
        if(!$quote) {
            $quote = $this->makeQuote();
        }
        
        $context = new Cart($quote,$this->em);
        return $context;

    }
    
    protected function makeQuote() {
        
        $quote = new QuoteEntity();
        $quote->setCreatedAt(Carbon::now());
        $quote->setUpdatedAt(Carbon::now());

        $siteId = Site::getSiteId();
        $site = $this->siteRepo->findById($siteId);

        $quote->setSite($site);

        $session = $this->sessionMgr->driver();
        $sessionId = $session->getId();

        $quote->setSessionId($sessionId);
        
        return $quote;
        
    }

}