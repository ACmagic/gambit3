<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160317022455 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('nfl_football_teams', function(Table $table) {

            $table->unsignedBigInteger('id');
            $table->string('machine_name',128)->setNotNull(true);
            $table->foreign('sports_teams','id','id',['onDelete'=>'CASCADE']);
            $table->primary('id');
            $table->unique('machine_name');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('nfl_football_teams');
    }
}
