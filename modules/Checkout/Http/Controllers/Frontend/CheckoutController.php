<?php

namespace Modules\Checkout\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Modules\Checkout\Forms\CheckoutForm;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Payum\Core\Model\ArrayObject as PayumArrayObject;
use Illuminate\Support\Facades\Redirect;
use Payum\Core\Request\GetHumanStatus;
use Illuminate\Session\SessionManager;
use Modules\Customer\Facades\Customer as CustomerFacade;
use Modules\Core\Facades\Store as StoreFacade;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Modules\Customer\Entities\Customer as CustomerEntity;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Validator;
use Modules\Customer\Facades\CustomerPool as CustomerPoolFacade;
use Modules\Sales\Repositories\QuoteRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Core\Repositories\StoreRepository;
use Modules\Sales\Entities\Quote as QuoteEntity;
use Modules\Sales\Entities\QuoteCredit as QuoteCreditEntity;
use Modules\Core\Facades\Site;
use Modules\Core\Repositories\SiteRepository;
use Illuminate\Support\Facades\Auth;
use Modules\Checkout\Facades\Cart as CartFacade;
use Modules\Sales\Repositories\SaleWorkflowStateRepository;
use Modules\Sales\Repositories\SaleItemWorkflowStateRepository;

class CheckoutController extends AbstractBaseController {

    /*use AuthenticatesUsers {
        showLoginForm as traitGetLogin;
        login as traitPostLogin;
    }

    use RegistersUsers {
        showRegistrationForm as traitGetRegister;
        register as traitPostRegister;
    }*/

    use AuthenticatesUsers;
    use RegistersUsers;

    use RedirectsUsers {
        RedirectsUsers::redirectPath insteadof AuthenticatesUsers;
        RedirectsUsers::redirectPath insteadof RegistersUsers;
    }

    // Location to redirect to after successful login.
    protected $redirectTo = 'checkout/gateway';

    // Set view used for login action.
    protected $loginView = 'checkout::frontend.checkout.login';

    // Set view used for registration action.
    protected $registerView = 'checkout::frontend.checkout.register';

    // The guard
    protected $guard = 'customers';

    // Session manager
    protected $session;

    // Entity manager.
    protected $em;

    // The quote repo.
    protected $quoteRepo;

    // The customer repo.
    protected $customerRepo;

    // The store repo.
    protected $storeRepo;

    // The site repo.
    protected $siteRepo;

    // Sale workflow state repo.
    protected $saleWorkflowRepo;

    /**
     * @var SaleItemWorkflowStateRepository
     */
    protected $saleItemWorkflowRepo;

    // Customer pool repository.

    public function __construct(
        SessionManager $session,
        EntityManagerInterface $em,
        QuoteRepository $quoteRepo,
        CustomerRepository $customerRepo,
        StoreRepository $storeRepo,
        SiteRepository $siteRepo,
        SaleWorkflowStateRepository $saleWorkflowRepo,
        SaleItemWorkflowStateRepository $saleItemWorkflowRepo
    ) {

        $this->session = $session;
        $this->em = $em;
        $this->quoteRepo = $quoteRepo;
        $this->customerRepo = $customerRepo;
        $this->storeRepo = $storeRepo;
        $this->siteRepo = $siteRepo;
        $this->saleWorkflowRepo = $saleWorkflowRepo;
        $this->saleItemWorkflowRepo = $saleItemWorkflowRepo;

    }
    
    public function getReview() {

        $quote = CartFacade::getQuote();
        return view('checkout::frontend.checkout.review',['quote'=> $quote]);

    }
    
    public function getComplete() {

        // @todo: Ingo coming back from paypal needs to include the quote ID.
        $quote = CartFacade::getQuote();

        $customerId = CustomerFacade::getCustomerId();
        $customer = $this->customerRepo->findById($customerId);

        $affordable = $customer->isAffordable($quote);
        if(!$affordable) {
            return redirect()->route('checkout.credits');
        }

        // @todo: Quote validation
        $paidState = $this->saleWorkflowRepo->findPaidState();
        $itemPaidState = $this->saleItemWorkflowRepo->findPaidState();

        $storeId = StoreFacade::getStoreId();
        $store = $this->storeRepo->findById($storeId);

        $sale = $quote->toSale();
        $sale->setCustomer($customer);
        $sale->setStore($store);
        $sale->setState($paidState);

        // Apply default item paid state to each item.
        foreach($sale->getItems() as $item) {
            $item->setState($itemPaidState);
        }

        // Update the quote with the sale info and expire.
        $quote->setSale($sale);
        $quote->setIsExpired(true);
        $quote->setIsCart(null);
        $quote->setExpiredAt(Carbon::now());

        $this->em->persist($sale);
        $this->em->persist($quote);

        $this->em->flush();

        // When a previous quote exists restore it.
        CartFacade::restoreQuote();

        // @todo: Set flash message and redirect to home page?

    }

    public function getGateway() {

        $args = [
            'method'=> 'POST',
            'route'=> ['checkout.gateway.post'],
            'step'=> 'gateway'
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        return view('checkout::frontend.checkout.gateway',['form'=> $form]);

    }

    public function postGateway() {

        $quoteId = $this->session->get('checkout.quoteId');
        $quote = $this->quoteRepo->findById($quoteId);

        // @todo: This should be more intelligent.
        if(!$quote) {
            abort(404);
        }

        $args = [
            'method'=> 'POST',
            'route'=> ['checkout.gateway.post'],
            'step'=> 'gateway'
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getRequest()->all();
        $payum = app('payum');

        $storage = $payum->getStorage(PayumArrayObject::class);

        // Get cost of quote.
        $cost = bcadd($quote->calculateTotalCost(),0,2);

        $details = $storage->create();

        switch($data['gateway']) {
            case 'paypal_ec':
                $details['PAYMENTREQUEST_0_CURRENCYCODE'] = 'USD';
                $details['PAYMENTREQUEST_0_AMT'] = $cost;
                break;

            /*case 'gambit_credit':
                $details['quote_id'] = $quote->getId();
                $details['cost'] = bcadd($quote->calculateTotalCost(),0,4);
                break;*/

            default:
        }

        $storage->update($details);

        $captureToken = $payum->getTokenFactory()->createCaptureToken($data['gateway'], $details, 'checkout.done');

        return Redirect::to($captureToken->getTargetUrl());

    }

    public function getDone($payum_token) {

        /** @var Request $request */
        $request = app('request');
        $payum = app('payum');

        $request->attributes->set('payum_token', $payum_token);

        $token = $payum->getHttpRequestVerifier()->verify($request);
        $gateway = $payum->getGateway($token->getGatewayName());

        $gateway->execute($status = new GetHumanStatus($token));

        /*
         * @todo: For now just create the sale here.
         */
        if ($status->isCaptured()) {

            // @todo: Ingo coming back from paypal needs to include the quote ID.
            $quoteId = $this->session->get('checkout.quoteId');
            $quote = $this->quoteRepo->findById($quoteId);

            $customerId = CustomerFacade::getCustomerId();
            $storeId = StoreFacade::getStoreId();

            $customer = $this->customerRepo->findById($customerId);
            $store = $this->storeRepo->findById($storeId);

            $processingState = $this->saleWorkflowRepo->findProcessedState();

            // @todo: What is the proper sale item state to be using?
            $itemPaidState = $this->saleItemWorkflowRepo->findPaidState();

            $sale = $quote->toSale();
            $sale->setCustomer($customer);
            $sale->setStore($store);
            $sale->setState($processingState);

            foreach($sale->getItems() as $item) {
                $item->setState($itemPaidState);
            }
            
            $this->em->persist($sale);
            $this->em->flush();

            $cartId = $this->session->get('checkout.cartId');

            if($cartId) {

                $this->session->forget('checkout.quoteId');
                $this->session->forget('checkout.cartId');
                return redirect()->route('checkout.review');

            } else {

                //return redirect()->route('checkout.');

            }

        }

        /*return response()->json(array(
            'status' => $status->getValue(),
            'details' => iterator_to_array($status->getFirstModel())
        ));*/
    }

    public function getLogin() {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.login.post',
            'step'=> 'login'
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        view()->composer($this->loginView,function($view) use ($form) {
            $view->with('form',$form);
        });

        return $this->showLoginForm();

    }

    public function postLogin(Request $request) {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.login.post',
            'step'=> 'login'
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        view()->composer($this->loginView,function($view) use ($form) {
            $view->with('form',$form);
        });

        return $this->login($request);

    }

    public function getRegister() {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.register.post',
            'step'=> 'register'
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        view()->composer($this->registerView,function($view) use ($form) {
            $view->with('form',$form);
        });

        return $this->showRegistrationForm();

    }

    public function postRegister(Request $request) {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.register.post',
            'step'=> 'register'
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        view()->composer($this->registerView,function($view) use ($form) {
            $view->with('form',$form);
        });

        return $this->register($request);

    }

    public function getCredits() {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.credits.post',
            'step'=> 'credits'
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        return view('checkout::frontend.checkout.credits',['form'=> $form]);

    }

    public function postCredits() {

        $quote = CartFacade::getQuote();

        $args = [
            'method'=> 'POST',
            'route'=> ['checkout.credits.post'],
            'step'=> 'credits',
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $quoteAmount = $quote->calculateTotalCost();
        $siteId = Site::getSiteId();
        $site = $this->siteRepo->findById($siteId);

        $customerId = CustomerFacade::getCustomerId();
        $customer = $this->customerRepo->findById($customerId);

        // Customers current balance.
        $balance = $customer->getInternalAccount()->getBalance();

        if($balance > 0) {
            $amount = bcsub($quoteAmount,$balance,2);
        } else {
            $amount = $quoteAmount;
        }

        /*
         * @todo: Should consider creating a factory to create boilerplate quote.
         */
        $newQuote = new QuoteEntity();
        $newQuote->setCreatedAt(Carbon::now());
        $newQuote->setUpdatedAt(Carbon::now());
        $newQuote->setExpiredAt(Carbon::now());
        $newQuote->setSite($site);
        $newQuote->setIsExpired(1);
        $newQuote->setCustomer($customer);
        $newQuote->setSessionId($this->session->driver()->getId());

        $item = new QuoteCreditEntity();
        $item->setQuote($newQuote);
        $item->setCreatedAt(Carbon::now());
        $item->setUpdatedAt(Carbon::now());
        $item->setAmount($amount);

        $newQuote->addItem($item);

        $this->em->persist($newQuote);
        $this->em->flush();

        $this->session->put('checkout.cartId',$quote->getId());
        $this->session->put('checkout.quoteId',$newQuote->getId());

        return redirect()->route('checkout.gateway');

    }

    /**
     * Create a new customer instance after a valid registration.
     *
     * @param  array  $data
     * @return CustomerEntity
     */
    protected function create(array $data) {

        $customer = new CustomerEntity();
        $customer->setEmail($data['email']);
        $customer->setPassword(bcrypt($data['password']));
        $customer->setCreatedAt(Carbon::now());
        $customer->setUpdatedAt(Carbon::now());

        CustomerPoolFacade::associateCustomer($customer);

        $this->em->persist($customer);
        $this->em->flush();

        return $customer;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {

        $poolId = CustomerPoolFacade::getCustomerPoolId();

        return Validator::make($data, [
            'email' => 'required|email|max:128|unique:'.CustomerEntity::class.',email,NULL,id,pool,'.$poolId,
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Use custom method to handle customer authenticated/logged in.
     *
     * @param Request $request
     *  The http request.
     *
     * @param CustomerEntity $customer
     *   The customer.
     */
    protected function authenticated(Request $request,CustomerEntity $customer) {

        $quote = CartFacade::getQuote();

        // Check quote affordability.
        $affordable = $customer->isAffordable($quote);

        if(!$affordable) {
            return redirect()->route('checkout.credits');
        } else {
            return redirect()->intended($this->redirectPath());
        }

    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        /*
         * This required because the session is migrated once
         * the user logs in. This results in the session ID changing.
         * Therefore, the current quote needs to be loaded so that
         * it can also be migrated over with the session via a event
         * subscriber.
         */
        $quote = CartFacade::getQuote();

        // NEVER DO THIS BEFORE fetching the quote.
        $this->guard()->login($this->create($request->all()));

        $customer = $this->guard()->user();

        // Check quote affordability.
        $affordable = $customer->isAffordable($quote);

        if(!$affordable) {
            return redirect()->route('checkout.credits');
        } else {
            return redirect($this->redirectPath());
        }

    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard($this->guard);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        return view($this->loginView);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm() {
        return view($this->registerView);
    }

}