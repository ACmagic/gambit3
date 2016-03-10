<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160310012242 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('advertised_lines', function(Table $table) {
            $table->bigIncrements('id');

            $table->bigInteger('line_id')->setUnsigned(true)->setNotnull(true);
            $table->bigInteger('customer_id')->setUnsigned(true)->setNotnull(true);

            // Numbers of line instances available.
            $table->integer('inventory')->setUnsigned(true)->setNotnull(true)->setDefault(1);

            // Amount
            $table->decimal('amount',19,4)->setUnsigned(true)->setNotnull(true);
            $table->decimal('amount_max',19,4)->setUnsigned(true)->setNotnull(false);

            $table->timestamps();

            $table->foreign('lines','line_id','id');
            $table->foreign('customers','customer_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('advertised_lines');

    }
}
