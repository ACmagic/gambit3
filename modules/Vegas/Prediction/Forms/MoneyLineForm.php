<?php namespace Modules\Vegas\Prediction\Forms;

use Kris\LaravelFormBuilder\Form;
use Modules\Sports\Entities\Game as GameEntity;

class MoneyLineForm extends Form {

    protected $game;

    public function buildForm() {

        $homeTeam = $this->game->getHomeTeam();
        $awayTeam = $this->game->getAwayTeam();

        $picks = [
            $homeTeam->getId()=> $homeTeam->getName(),
            $awayTeam->getId()=> $awayTeam->getName(),
        ];

        $this
            ->add('pick','choice',[
                'expanded'=> true,
                'choices'=> $picks,
                'label'=> 'Pick:',
            ]);
    }

    public function setFormOptions($formOptions) {

        parent::setFormOptions($formOptions);

        $this->pullFromOptions('predictable', 'setGameEntity');

        return $this;

    }

    public function setGameEntity(GameEntity $game) {
        $this->game = $game;
    }

}