<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160917062642 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('lines', function(Table $table) {

            // Add rolling calculated column date.
            $table->integer('rolling_inventory')->setUnsigned(true)->setNotnull(true)->setDefault(0);
            $table->decimal('rolling_amount',19,4)->setUnsigned(true)->setNotnull(true)->setDefault(0);
            $table->decimal('rolling_amount_max',19,4)->setUnsigned(true)->setNotnull(false)->setDefault(0);

            // Add realtime calculated column data.
            $table->integer('realtime_inventory')->setUnsigned(true)->setNotnull(true)->setDefault(0);
            $table->decimal('realtime_amount',19,4)->setUnsigned(true)->setNotnull(true)->setDefault(0);
            $table->decimal('realtime_amount_max',19,4)->setUnsigned(true)->setNotnull(false)->setDefault(0);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('lines', function(Table $table) {

            $table->dropColumn('rolling_inventory');
            $table->dropColumn('rolling_amount');
            $table->dropColumn('rolling_amount_max');
            $table->dropColumn('realtime_inventory');
            $table->dropColumn('realtime_amount');
            $table->dropColumn('realtime_amount_max');

        });

    }
}