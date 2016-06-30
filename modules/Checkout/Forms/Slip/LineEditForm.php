<?php namespace Modules\Checkout\Forms\Slip;

use Kris\LaravelFormBuilder\Form as BaseForm;
use Modules\Sales\Entities\QuoteAdvertisedLine;
use Modules\Catalog\Repositories\SideRepository;

class LineEditForm extends BaseForm {

    protected $advertisedLine;

    protected $sideRepo;

    public function __construct(SideRepository $sideRepo) {
        $this->sideRepo = $sideRepo;
    }

    public function buildForm() {

        $sideChoices = [];
        $sides = $this->sideRepo->findAll();
        foreach($sides as $side) {
            $sideChoices[$side->getId()] = $side->getHumanName();
        }

        $this->add('side','choice',[
            'label'=> 'Side:',
            'choices'=> $sideChoices,
            'default_value'=> $this->advertisedLine->getSide()->getId(),
            'rules'=> 'required|min:1',
        ]);

        $this->add('odds','text',[
            'label'=> 'Odds:',
            'default_value'=> $this->advertisedLine->getOdds(),
            'rules'=> 'required|min:1|numeric',
        ]);

        $this->add('amount','text',[
            'label'=> 'Wager Min:',
            'default_value'=> $this->advertisedLine->getAmount(),
            'rules'=> 'required|min:1',
        ]);

        $this->add('amountMax','text',[
            'label'=> 'Wager Max:',
            'default_value'=> $this->advertisedLine->getAmountMax(),
            'rules'=> 'min:1',
        ]);

        $this->add('inventory','text',[
            'label'=> 'Inventory:',
            'default_value'=> $this->advertisedLine->getInventory(),
            'rules'=> 'required|numeric|min:1',
        ]);

        $this->add('submit','submit',[
            'label'=> 'Save',
        ]);

    }

    public function setFormOptions($formOptions) {

        parent::setFormOptions($formOptions);

        $this->pullFromOptions('advertisedLine', 'setAdvertisedLine');

        return $this;

    }

    /**
     * Bind the advertised line.
     *
     * @param QuoteAdvertisedLine $advertisedLine
     *   The advertised line.
     */
    public function setAdvertisedLine(QuoteAdvertisedLine $advertisedLine) {
        $this->advertisedLine = $advertisedLine;
    }

}