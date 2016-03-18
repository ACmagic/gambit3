<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160318010310 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('money_lines', function(Table $table) {

            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('pick_id')->setNotnull(true);
            $table->foreign('predictions','id','id',['onDelete'=>'CASCADE']);
            $table->foreign('sports_teams','pick_id','id');
            $table->primary('id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('money_lines');
    }
}
