<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20161124074604 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('charge_backs', function(Table $table) {

            // Amount
            $table->decimal('amount',19,4)->setUnsigned(true)->setNotnull(true);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('charge_backs', function(Table $table) {

            $table->dropColumn('amount');

        });

    }
}
