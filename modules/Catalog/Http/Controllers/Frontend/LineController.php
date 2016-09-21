<?php

namespace Modules\Catalog\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Modules\Catalog\Repositories\InverseLineRepository;
use Modules\Catalog\Forms\AcceptLineForm;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Illuminate\Session\SessionManager;
use Modules\Core\Facades\Site;
use Modules\Core\Repositories\SiteRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Carbon\Carbon;
use Modules\Sales\Entities\Quote as QuoteEntity;
use Modules\Customer\Facades\Customer as CustomerFacade;
use Modules\Sales\Entities\QuoteAcceptedLine;
use Modules\Catalog\Repositories\AdvertisedLineRepository;
use Doctrine\ORM\EntityManagerInterface;

class LineController extends AbstractBaseController
{

    /**
     * @var SessionManager
     */
    protected $sessionMgr;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var SiteRepository
     */
    protected $siteRepo;

    /**
     * @var CustomerRepository
     */
    protected $customerRepo;

    /**
     * @var AdvertisedLineRepository
     */
    protected $advertisedLineRepo;

    /**
     * @var InverseLineRepository
     */
    protected $inverseLineRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param SessionManager $sessionMgr
     *   The session manager.
     *
     * @param EntityManagerInterface $em
     *   The entity manager.
     *
     * @param SiteRepository $siteRepo
     *   The site repo.
     *
     * @param CustomerRepository $customerRepo
     *   The customer repo.
     *
     * @param AdvertisedLineRepository $advertisedLineRepo
     *   The advertised line repo.
     *
     * @param InverseLineRepository $inverseLineRepository
     *   The advertised line repository.
     */
    public function __construct(
        SessionManager $sessionMgr,
        EntityManagerInterface $em,
        SiteRepository $siteRepo,
        CustomerRepository $customerRepo,
        AdvertisedLineRepository $advertisedLineRepo,
        InverseLineRepository $inverseLineRepository
    )
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->sessionMgr = $sessionMgr;
        $this->em = $em;
        $this->siteRepo = $siteRepo;
        $this->customerRepo = $customerRepo;
        $this->advertisedLineRepo = $advertisedLineRepo;
        $this->inverseLineRepository = $inverseLineRepository;

        // middleware to require login

    }

    public function getIndex() {

        //$sites = $this->siteRepository->findAll();

        $lines = $this->inverseLineRepository->findAllStoresOpenLines();

        return view('catalog::frontend.line.index',['lines'=>$lines]);

    }

    public function getAccept($lineId) {

        $line = $this->inverseLineRepository->findById($lineId);

        $args = [
            'method'=> 'POST',
            'route'=> ['line.accept.post',$lineId],
            'line'=> $line,
        ];
        $form = FormBuilder::create(AcceptLineForm::class,$args);

        return view('catalog::frontend.line.accept',['form'=>$form]);

    }

    public function postAccept($lineId) {

        $line = $this->inverseLineRepository->findById($lineId);

        $args = [
            'method'=> 'POST',
            'route'=> ['line.accept.post',$lineId],
            'line'=> $line,
        ];
        $form = FormBuilder::create(AcceptLineForm::class,$args);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getRequest()->all();

        // @todo: This will throw an exception if advertised lines aren't available.
        $advertisedLines = $this->advertisedLineRepo->matchAvailable($line,$data['amount'],$data['quantity']);

        $quote = new QuoteEntity();
        $quote->setIsCart(0);
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

        $desiredQuantity = $data['quantity'];
        foreach($advertisedLines as $advertisedLine) {

            if($desiredQuantity >= $advertisedLine->getInventory()) {
                $desiredQuantity = $advertisedLine->getInventory();
            }

            $item = new QuoteAcceptedLine();
            $item->setQuote($quote);
            $quote->addItem($item);

            $item->setCreatedAt(Carbon::now());
            $item->setUpdatedAt(Carbon::now());
            $item->setAdvertisedLine($advertisedLine);
            $item->setAmount($data['amount']);
            $item->setQuantity($desiredQuantity);

        }

        if(!$quote->getCustomer() || !$quote->getCustomer()->isAffordable($quote)) {

            $this->em->persist($quote);
            $this->em->flush();

            if($quote->getCustomer()) {
                return redirect()->route('checkout.credits');
            } else {
                return redirect()->route('checkout.login');
            }

        }

        // Purchase immediately.
        // @todo: Should we add a review step??
        $sale = $quote->toSale();
        $this->em->persist($sale);
        $this->em->flush();


    }

}