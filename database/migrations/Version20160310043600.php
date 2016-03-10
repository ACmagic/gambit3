<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160310043600 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('accepted_lines', function(Table $table) {
            $table->bigIncrements('id');

            $table->bigInteger('advertised_line_id')->setUnsigned(true)->setNotnull(true);
            $table->bigInteger('customer_id')->setUnsigned(true)->setNotnull(true);

            // Amount
            $table->decimal('amount',19,4)->setUnsigned(true)->setNotnull(true);

            $table->timestamps();

            $table->foreign('advertised_lines','advertised_line_id','id');
            $table->foreign('customers','customer_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('accepted_lines');
    }
}
