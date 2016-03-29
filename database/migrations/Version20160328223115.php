<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160328223115 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('point_spreads', function(Table $table) {

            $table->unsignedBigInteger('game_id')->setNotnull(true);
            $table->foreign('sports_games','game_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('point_spreads', function(Table $table) {

            $table->dropColumn('game_id');

        });

    }
}
