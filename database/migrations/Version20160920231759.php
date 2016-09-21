<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160920231759 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('sale_accepted_lines', function(Table $table) {

            $table->integer('quantity')->setUnsigned(true)->setNotnull(true)->setDefault(1);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('sale_accepted_lines', function(Table $table) {

            $table->dropColumn('quantity');

        });

    }
}
