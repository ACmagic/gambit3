<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160317022050 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('nfl_football_games', function(Table $table) {

            $table->unsignedBigInteger('id');

            /**
             * This can't be done because foreign key is assumed to map
             * to root level parent. Thus, the only parent that is inserted
             * before the child is the root level parent. The rest of the ordering
             * is arbitrary in doctrine.
             */
            //$table->foreign('sports_games','id','id',['onDelete'=>'CASCADE']);
            $table->foreign('events','id','id',['onDelete'=>'CASCADE']);

            $table->primary('id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('nfl_football_games');

    }
}
