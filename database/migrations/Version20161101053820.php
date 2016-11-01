<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20161101053820 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('charge_backs', function(Table $table) {

            $table->bigIncrements('id')->setUnsigned(true);
            $table->unsignedBigInteger('sale_id')->setNotnull(true);
            $table->boolean('payback')->setDefault(0)->setNotnull(true);
            $table->text('memo')->setNotnull(true);
            $table->timestamps();

            $table->foreign('sales','sale_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('charge_backs');

    }
}
