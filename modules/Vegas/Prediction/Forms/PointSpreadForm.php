<?php namespace Modules\Vegas\Prediction\Forms;

use Kris\LaravelFormBuilder\Form;
use Modules\Sports\Entities\Game as GameEntity;
use Modules\Prediction\PredictionType;
use Modules\Prediction\PredictableResolver;

class PointSpreadForm extends Form {

    protected $game;
    protected $predictionType;
    protected $predictableResolver;

    public function buildForm() {

        $homeTeam = $this->game->getHomeTeam();
        $awayTeam = $this->game->getAwayTeam();

        $picks = [
            $homeTeam->getId()=> $homeTeam->getName(),
            $awayTeam->getId()=> $awayTeam->getName(),
        ];

        $this
            ->add('prediction_name','hidden',[
                'value'=> $this->predictionType->getName(),
                'rules'=> 'required',
            ])
            ->add('predictable_type','hidden',[
                'value'=> $this->predictableResolver->getName(),
                'rules'=> 'required',
            ])
            ->add('predictable_id','hidden',[
                'value'=> $this->predictableResolver->pluckId($this->game),
                'rules'=> 'required',
            ])
            ->add('pick','choice',[
                'expanded'=> true,
                'choices'=> $picks,
                'label'=> 'Pick:',
                'rules'=> 'required',
            ])
            ->add('spread','text',[
                'rules'=> 'required|integer',
                'label'=> 'Spread:',
            ])
            ->add('submit','submit',[
                'label'=> 'Add',
            ]);

    }

    public function setFormOptions($formOptions) {

        parent::setFormOptions($formOptions);

        $this->pullFromOptions('predictable', 'setGameEntity');
        $this->pullFromOptions('prediction_type', 'setPredictionType');
        $this->pullFromOptions('predictable_resolver', 'setPredictableResolver');

        return $this;

    }

    public function setGameEntity(GameEntity $game) {
        $this->game = $game;
    }

    public function setPredictionType(PredictionType $type) {
        $this->predictionType = $type;
    }

    public function setPredictableResolver(PredictableResolver $resolver) {
        $this->predictableResolver = $resolver;
    }

}