<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160317013311 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('sports_games', function(Table $table) {

            $table->unsignedBigInteger('home_team_id')->setNotnull(true);
            $table->unsignedBigInteger('away_team_id')->setNotnull(true);

            $table->foreign('sports_teams','home_team_id','id');
            $table->foreign('sports_teams','away_team_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('sports_games', function(Table $table) {

            $table->dropColumn('home_team_id');
            $table->dropColumn('away_team_id');

        });

    }
}
