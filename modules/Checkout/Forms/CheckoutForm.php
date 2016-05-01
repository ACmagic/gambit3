<?php namespace Modules\Checkout\Forms;

use Kris\LaravelFormBuilder\Form as BaseForm;

class CheckoutForm extends BaseForm {

    protected $step;

    public function buildForm() {

        switch($this->step) {

            case 'gateway':
                $this->buildStep2();
                break;

            case 'login':
                $this->buildLogin();
                break;

            case 'register':
                $this->buildRegister();
                break;

            default:
                $this->buildStep1();

        }

    }

    protected function buildStep1() {

        $amounts = [
            50=> '50',
            100=> '100',
            250=> '250',
            500=> '500',
        ];

        $this->add('amount','choice',[
            'expanded'=> true,
            'choices'=> $amounts,
            'label'=> 'Credits:',
            'rules'=> 'required',
        ])->add('submit','submit',[
            'label'=> 'Next',
        ]);

    }

    protected function buildStep2() {

        $gateways = [
            'paypal_ec'=> 'Paypal Express Checkout',
        ];

        $this->add('gateway','choice',[
            'expanded'=> true,
            'choices'=> $gateways,
            'label'=> 'Payment Method:',
            'rules'=> 'required',
        ])->add('submit','submit',[
            'label'=> 'Next',
        ]);

    }

    protected function buildLogin() {

        $this->add('email','text',[
            'label'=> 'Email:',
            'rules'=> 'required',
        ]);

        $this->add('password','password',[
            'label'=> 'Password:',
            'rules'=> 'required',
        ]);

        $this->add('submit','submit',[
            'label'=> 'Login',
        ]);

    }

    protected function buildRegister() {

        $this->add('email','text',[
            'label'=> 'Email:',
            'rules'=> 'required',
        ]);

        $this->add('password','password',[
            'label'=> 'Password:',
            'rules'=> 'required',
        ]);

        $this->add('password_confirmation','password',[
            'label'=> 'Password:',
            'rules'=> 'required',
        ]);

        $this->add('submit','submit',[
            'label'=> 'Register',
        ]);

    }

    public function setFormOptions($formOptions) {

        parent::setFormOptions($formOptions);

        $this->pullFromOptions('step', 'setStep');

        return $this;

    }

    public function setStep($step) {
        $this->step = $step;
    }

}