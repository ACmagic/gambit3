<?php namespace Modules\Credits\Forms;

use Kris\LaravelFormBuilder\Form as BaseForm;

class AddCreditsForm extends BaseForm {

    public function buildForm() {

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

}