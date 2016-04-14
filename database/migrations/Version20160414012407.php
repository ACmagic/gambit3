<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160414012407 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('customer_accounts', function(Table $table) {

            $table->bigInteger('customer_id')->setUnsigned(true)->setNotnull(true);
            $table->bigInteger('account_id')->setUnsigned(true)->setNotnull(true);

            $table->foreign('customers','customer_id','id');
            $table->foreign('accounts','account_id','id');

            $table->primary(['customer_id','account_id']);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('customer_accounts');
    }
}
