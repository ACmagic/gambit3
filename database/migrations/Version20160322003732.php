<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160322003732 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('quotes', function(Table $table) {

            $table->bigIncrements('id')->setUnsigned(true);
            $table->unsignedInteger('site_id')->setNotnull(true);
            $table->unsignedBigInteger('customer_id')->setNotnull(false);
            $table->string('session_id')->setNotnull(true);
            $table->timestamps();
            $table->foreign('sites','site_id','id');
            $table->foreign('customers','customer_id','id');
            $table->unique(['site_id','session_id']);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('quotes');

    }
}
