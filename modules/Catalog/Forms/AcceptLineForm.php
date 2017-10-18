<?php namespace Modules\Catalog\Forms;

use Kris\LaravelFormBuilder\Form as BaseForm;
use Modules\Catalog\Contracts\Entities\Line as LineContract;

class AcceptLineForm extends BaseForm {

    /**
     * @var LineContract
     */
    protected $line;

    public function buildForm() {

        $amount = bcadd($this->line->getRealTimeAmount(),0,0);
        $amountMax = bcadd($this->line->getRealTimeAmountMax(),0,0);

        if(bccomp($this->line->getRealTimeAmount(),$this->line->getRealTimeAmountMax(),4) === 0) {
            $amountVal = 'size:'.$amount;
        } else {
            $amountVal = 'between:'.$amount.','.$amountMax;
        }

        if($this->line->getRealTimeInventory() == 1) {
            $quantityVal = 'size:1';
        } else {
            $quantityVal = 'between:1,'.$this->line->getRealTimeInventory();
        }

        $this->add('amount','number',[
            'label'=> 'Amount:',
            'type'=> 'number',
            'default_value'=> $amount,
            'rules'=> 'required|integer|'.$amountVal,
        ]);

        $this->add('quantity','number',[
            'label'=> 'Quantity:',
            'type'=> 'number',
            'default_value'=> 1,
            'rules'=> 'required|integer|'.$quantityVal,
        ]);

        $this->add('submit','submit',[
            'label'=> 'Accept',
        ]);

    }

    public function setFormOptions(array $formOptions) {

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