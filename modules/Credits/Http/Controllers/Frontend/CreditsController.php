<?php

namespace Modules\Credits\Http\Controllers\Frontend;
use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Modules\Credits\Forms\AddCreditsForm;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Modules\Customer\Facades\Customer as CustomerFacade;
use Illuminate\Session\SessionManager;
use Modules\Sales\Entities\Quote as QuoteEntity;
use Modules\Sales\Entities\QuoteCredit as QuoteCreditEntity;
use Carbon\Carbon;
use Modules\Core\Facades\Site;
use Doctrine\ORM\EntityManagerInterface;
use Modules\Core\Repositories\SiteRepository;

class CreditsController extends AbstractBaseController {

    protected $session;
    protected $em;
    protected $siteRepo;

    public function __construct(SessionManager $session,EntityManagerInterface $em,SiteRepository $siteRepo) {
        $this->session = $session;
        $this->em = $em;
        $this->siteRepo = $siteRepo;
    }

    public function getAddCredits() {

        $args = [
            'method'=> 'POST',
            'route'=> 'credits.add.post',
        ];
        $form = FormBuilder::create(AddCreditsForm::class,$args);

        return view('credits::frontend.credits.add',['form'=> $form]);

    }

    public function postAddCredits() {

        $args = [
            'method'=> 'POST',
            'route'=> 'credits.add.post',
        ];
        $form = FormBuilder::create(AddCreditsForm::class,$args);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getRequest()->all();

        $siteId = Site::getSiteId();
        $site = $this->siteRepo->findById($siteId);

        /*
         * @todo: Should consider creating a factory to create boilerplate quote.
         */
        $quote = new QuoteEntity();
        $quote->setCreatedAt(Carbon::now());
        $quote->setUpdatedAt(Carbon::now());
        $quote->setExpiredAt(Carbon::now());
        $quote->setSite($site);
        $quote->setIsExpired(1);
        $quote->setSessionId($this->session->driver()->getId());

        $item = new QuoteCreditEntity();
        $item->setQuote($quote);
        $item->setCreatedAt(Carbon::now());
        $item->setUpdatedAt(Carbon::now());
        $item->setAmount($data['amount']);

        $quote->addItem($item);

        $this->em->persist($quote);
        $this->em->flush();

        $this->session->put('checkout.quoteId',$quote->getId());

        $loggedIn = CustomerFacade::isLoggedIn();
        if($loggedIn) {
            return redirect()->route('checkout.gateway');
        } else {
            return redirect()->route('checkout.login');
        }

    }

}