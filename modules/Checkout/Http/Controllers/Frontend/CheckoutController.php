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
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Modules\Customer\Entities\Customer as CustomerEntity;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Validator;
use Modules\Customer\Facades\CustomerPool as CustomerPoolFacade;
use Modules\Sales\Repositories\QuoteRepository;

class CheckoutController extends AbstractBaseController {

    use AuthenticatesAndRegistersUsers {
        getLogin as traitGetLogin;
        postLogin as traitPostLogin;
        getRegister as traitGetRegister;
        postRegister as traitPostRegister;
    }

    use ThrottlesLogins;

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

    // Customer pool repository.

    public function __construct(SessionManager $session,EntityManagerInterface $em,QuoteRepository $quoteRepo) {

        $this->session = $session;
        $this->em = $em;
        $this->quoteRepo = $quoteRepo;

    }

    /*public function getIndex() {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.post',
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        return view('checkout::frontend.checkout.index',['form'=> $form]);

    }*/

    /*public function postIndex() {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.post',
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getRequest()->all();

        $this->session->put('checkout.credits.amount',$data['amount']);

        $loggedIn = CustomerFacade::isLoggedIn();
        if($loggedIn) {
            return redirect()->route('checkout.credits.gateway');
        } else {
            return redirect()->route('checkout.credits.login');
        }

    }*/

    public function getGateway() {

        $args = [
            'method'=> 'POST',
            'route'=> ['checkout.gateway.post'],
            'step'=> 'gateway',
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
            'step'=> 'gateway',
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $payum = app('payum');

        $storage = $payum->getStorage(PayumArrayObject::class);

        $cost = bcadd($quote->calculateTotalCost(),0,2);

        $details = $storage->create();
        $details['PAYMENTREQUEST_0_CURRENCYCODE'] = 'USD';
        $details['PAYMENTREQUEST_0_AMT'] = $cost;
        $storage->update($details);

        $captureToken = $payum->getTokenFactory()->createCaptureToken('paypal_ec', $details, 'checkout.done');

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

        return response()->json(array(
            'status' => $status->getValue(),
            'details' => iterator_to_array($status->getFirstModel())
        ));
    }

    public function getLogin() {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.login.post',
            'step'=> 'login',
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        view()->composer($this->loginView,function($view) use ($form) {
            $view->with('form',$form);
        });

        return $this->traitGetLogin();

    }

    public function postLogin(Request $request) {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.login.post',
            'step'=> 'login',
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        view()->composer($this->loginView,function($view) use ($form) {
            $view->with('form',$form);
        });

        return $this->traitPostLogin($request);

    }

    public function getRegister() {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.register.post',
            'step'=> 'register',
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        view()->composer($this->registerView,function($view) use ($form) {
            $view->with('form',$form);
        });

        return $this->traitGetRegister();

    }

    public function postRegister(Request $request) {

        $args = [
            'method'=> 'POST',
            'route'=> 'checkout.register.post',
            'step'=> 'register',
        ];
        $form = FormBuilder::create(CheckoutForm::class,$args);

        view()->composer($this->registerView,function($view) use ($form) {
            $view->with('form',$form);
        });

        return $this->traitPostRegister($request);

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

}