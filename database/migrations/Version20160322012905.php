<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160322012905 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('quote_money_lines', function(Table $table) {

            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('pick_id')->setNotnull(true);
            $table->foreign('sports_teams','pick_id','id');
            $table->foreign('quote_predictions','id','id',['onDelete'=>'CASCADE']);
            $table->primary('id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('quote_money_lines');

    }
}
