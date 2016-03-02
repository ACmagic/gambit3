<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160302020208 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('customers', function(Table $table) {
            $table->bigIncrements('id');

            $table->integer('pool_id')->setUnsigned(true)->setNotnull(true);

            $table->string('email',128);
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('customer_pool','pool_id','id');
            $table->unique(['pool_id','email']);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('customers');
    }
}
