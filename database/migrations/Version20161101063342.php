<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20161101063342 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('lines', function(Table $table) {

            $table->smallInteger('winning_side_id')->setUnsigned(true)->setNotnull(false);
            $table->foreign('sides','winning_side_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('lines', function(Table $table) {

            $table->dropColumn('winning_side_id');

        });

    }
}
