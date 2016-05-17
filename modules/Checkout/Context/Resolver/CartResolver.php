<?php namespace Modules\Checkout\Context\Resolver;

use Modules\Core\Context\Resolver;
use Modules\Checkout\Cart;
use Modules\Sales\Entities\Quote as QuoteEntity;
use Modules\Sales\Repositories\QuoteRepository;
use Illuminate\Session\SessionManager;
use Modules\Core\Facades\Site;
use Modules\Core\Repositories\SiteRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Modules\Customer\Facades\Customer as CustomerFacade;

class CartResolver implements Resolver {

    protected $quoteRepository;
    protected $sessionMgr;
    protected $siteRepo;
    protected $customerRepo;
    protected $em;

    public function __construct(
        QuoteRepository $quoteRepository,
        SessionManager $sessionMgr,
        SiteRepository $siteRepo,
        EntityManagerInterface $em,
        CustomerRepository $customerRepo
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->sessionMgr = $sessionMgr;
        $this->siteRepo = $siteRepo;
        $this->customerRepo = $customerRepo;
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

        $quote = $this->quoteRepository->findActiveSessionCart($sessionId,$siteId);
        if(!$quote) {
            $quote = $this->makeQuote();
        }
        
        $context = new Cart($quote,$this->em);
        return $context;

    }
    
    protected function makeQuote() {
        
        $quote = new QuoteEntity();
        $quote->setIsCart(1);
        $quote->setIsExpired(0);
        $quote->setCreatedAt(Carbon::now());
        $quote->setUpdatedAt(Carbon::now());

        $siteId = Site::getSiteId();
        $site = $this->siteRepo->findById($siteId);

        $quote->setSite($site);

        if(CustomerFacade::isLoggedIn()) {
            $customer = $this->customerRepo->findById(CustomerFacade::getCustomerId());
            $quote->setCustomer($customer);
        }

        $session = $this->sessionMgr->driver();
        $sessionId = $session->getId();

        $quote->setSessionId($sessionId);
        
        return $quote;
        
    }

}