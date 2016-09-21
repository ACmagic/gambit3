<?php namespace Modules\Catalog\Forms;

use Kris\LaravelFormBuilder\Form as BaseForm;
use Modules\Catalog\Contracts\Entities\Line as LineContract;

class AcceptLineForm extends BaseForm {

    /**
     * @var LineContract
     */
    protected $line;

    public function buildForm() {

        $this->add('amount','text',[
            'label'=> 'Amount:',
            'default_value'=> $this->line->getRealTimeAmount(),
            'rules'=> 'required|numeric|min:'.$this->line->getRealTimeAmount().'|max:'.$this->line->getRealTimeAmountMax(),
        ]);

        $this->add('quantity','text',[
            'label'=> 'Quantity:',
            'default_value'=> 1,
            'rules'=> 'required|numeric|min:1',
        ]);

        $this->add('submit','submit',[
            'label'=> 'Accept',
        ]);

    }

    public function setFormOptions($formOptions) {

        parent::setFormOptions($formOptions);

        $this->pullFromOptions('line', 'setLine');

        return $this;

    }

    /**
     * Bind the line.
     *
     * @param LineContract $line
     *   The line.
     */
    public function setLine(LineContract $line) {
        $this->line = $line;
    }

}