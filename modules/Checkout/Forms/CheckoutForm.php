<?php namespace Modules\Checkout\Forms;

use Kris\LaravelFormBuilder\Form as BaseForm;
use Modules\Sales\Entities\Quote as QuoteEntity;

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

            case 'credits':
                $this->buildCredits();
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

        $this->setFormOption('class','form-horizontal');

        $gateways = [
            'paypal_ec'=> 'Paypal Express Checkout',
        ];

        $this->add('gateway','choice',[
            'expanded'=> true,
            'choices'=> $gateways,
            'label'=> 'Payment Method:',
            'rules'=> 'required',
            'label_attr'=> ['class'=> 'col-sm-2 control-label'],
        ])->add('submit','submit',[
            'label'=> 'Next',
            'attr'=> ['class'=> 'btn btn-primary' ],
            'wrapper'=> ['class'=>'pull-right'],
        ]);

    }

    protected function buildLogin() {

        $this->setFormOption('class','form-horizontal');

        $this->add('email','text',[
            'label'=> 'Email:',
            'rules'=> 'required',
            'label_attr'=> ['class'=> 'col-sm-2 control-label'],
        ]);

        $this->add('password','password',[
            'label'=> 'Password:',
            'rules'=> 'required',
            'label_attr'=> ['class'=> 'col-sm-2 control-label'],
        ]);

        $this->add('submit','submit',[
            'label'=> 'Login',
            'attr'=> ['class'=> 'btn btn-primary' ],
            'wrapper'=> ['class'=>'pull-right'],
        ]);

    }

    protected function buildRegister() {

        $this->setFormOption('class','form-horizontal');

        $this->add('email','text',[
            'label'=> 'Email:',
            'rules'=> 'required',
            'label_attr'=> ['class'=> 'col-sm-2 control-label'],
        ]);

        $this->add('password','password',[
            'label'=> 'Password:',
            'rules'=> 'required',
            'label_attr'=> ['class'=> 'col-sm-2 control-label'],
        ]);

        $this->add('password_confirmation','password',[
            'label'=> 'Confirm Password:',
            'rules'=> 'required',
            'label_attr'=> ['class'=> 'col-sm-2 control-label'],
        ]);

        $this->add('submit','submit',[
            'label'=> 'Register',
            'attr'=> ['class'=> 'btn btn-primary' ],
            'wrapper'=> ['class'=>'pull-right'],
        ]);

    }

    protected function buildCredits() {

        $this->add('submit','submit',[
            'label'=> 'Purchase Credits',
            'attr'=> ['class'=> 'btn btn-primary' ],
        ]);

    }

    public function setFormOptions(array $formOptions) {

        parent::setFormOptions($formOptions);

        $this->pullFromOptions('step', 'setStep');

        return $this;

    }

    public function setStep($step) {
        $this->step = $step;
    }

}