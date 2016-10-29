<?php namespace Modules\Checkout\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Modules\Checkout\Facades\Cart as CartFacade;
use Modules\Checkout\Forms\Slip\LineEditForm;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Session\SessionManager;
use Modules\Customer\Facades\Customer as CustomerFacade;
use Modules\Catalog\Repositories\SideRepository;

class SlipController extends AbstractBaseController {

    protected $em;
    protected $session;

    protected $sideRepo;

    public function __construct(
        SessionManager $session,
        EntityManagerInterface $em,
        SideRepository $sideRepo
    ) {
        $this->em = $em;
        $this->session = $session;
        $this->sideRepo = $sideRepo;
    }

    public function getIndex() {

        $quote = CartFacade::getQuote();

        return view('checkout::frontend.slip.index',['quote'=>$quote]);

    }

    public function getCheckout() {

        $loggedIn = CustomerFacade::isLoggedIn();
        if($loggedIn) {
            return redirect()->route('checkout.review');
        } else {
            return redirect()->route('checkout.login');
        }

    }

    public function getLineEdit($index) {

        $quote = CartFacade::getQuote();
        $items = $quote->getAdvertisedLineItems();

        $advertisedLine = $items[$index-1];

        $args = [
            'method'=> 'POST',
            'route'=> ['slip.line_edit.post',$index],
            'advertisedLine'=> $advertisedLine,
        ];
        $form = FormBuilder::create(LineEditForm::class,$args);

        return view('checkout::frontend.slip.line-edit',['form'=>$form]);

    }

    public function postLineEdit($index) {

        $quote = CartFacade::getQuote();
        $items = $quote->getAdvertisedLineItems();

        $advertisedLine = $items[$index-1];

        $args = [
            'method'=> 'POST',
            'route'=> ['slip.line_edit.post',$index],
            'advertisedLine'=> $advertisedLine,
        ];
        $form = FormBuilder::create(LineEditForm::class,$args);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getRequest()->all();

        $side = $this->sideRepo->findById($data['side']);

        $advertisedLine->setSide($side);
        $advertisedLine->setOdds($data['odds']);
        //$advertisedLine->setInverseOdds($data['inverse_odds']);
        $advertisedLine->setAmount($data['amount']);
        $advertisedLine->setInventory($data['inventory']);

        if($data['amountMax']) {
            $advertisedLine->setAmountMax($data['amountMax']);
        }

        $this->em->persist($advertisedLine);
        $this->em->flush();

        return redirect()->route('slip');

    }

}