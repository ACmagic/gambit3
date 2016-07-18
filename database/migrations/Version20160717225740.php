<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160717225740 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('sale_advertised_lines', function(Table $table) {

            /*
             * This is the whole reason the application currently requires >= MySQL 5.7.8. Anything
             * less will not have native json column(s). The native json column is necessary to use native MySQL
             * json search functions which are relied on in the application.
             */
            $table->json('predictions_cache')->setNotnull(false);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('sale_advertised_lines', function(Table $table) {

            $table->dropColumn('predictions_cache');

        });

    }
}
