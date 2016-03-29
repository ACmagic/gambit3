<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160322021143 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('sales', function(Table $table) {

            $table->bigIncrements('id')->setUnsigned(true);
            $table->unsignedInteger('store_id')->setNotnull(true);
            $table->unsignedBigInteger('customer_id')->setNotnull(true);
            $table->timestamps();
            $table->foreign('stores','store_id','id');
            $table->foreign('customers','customer_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('sales');

    }
}
