<?php namespace Modules\Vegas\Prediction\Forms;

use Kris\LaravelFormBuilder\Form;

class MoneyLineForm extends Form {

    public function buildForm() {
        $this
            ->add('name', 'text', [
                'rules' => 'required|min:5'
            ])
            ->add('lyrics', 'textarea', [
                'rules' => 'max:5000'
            ])
            ->add('publish', 'checkbox');
    }

}