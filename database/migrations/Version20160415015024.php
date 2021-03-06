<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160415015024 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('sale_money_lines', function(Table $table) {

            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('pick_id')->setNotnull(true);
            $table->unsignedBigInteger('game_id')->setNotnull(true);
            $table->foreign('sports_teams','pick_id','id');
            $table->foreign('sports_games','game_id','id');
            $table->foreign('sale_predictions','id','id',['onDelete'=>'CASCADE']);
            $table->primary('id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('sale_money_lines');
    }
}
