<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20161029045238 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('sports_games', function(Table $table) {

            $table->decimal('home_team_score',7,2)->setUnsigned(true)->setNotnull(true)->setDefault(0);
            $table->decimal('away_team_score',7,2)->setUnsigned(true)->setNotnull(true)->setDefault(0);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('sports_games', function(Table $table) {

            $table->dropColumn('home_team_score');
            $table->dropColumn('away_team_score');

        });

    }
}
