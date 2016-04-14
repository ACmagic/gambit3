<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160414004642 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('site_accounts', function(Table $table) {

            $table->integer('site_id')->setUnsigned(true)->setNotnull(true);
            $table->bigInteger('account_id')->setUnsigned(true)->setNotnull(true);

            $table->foreign('sites','site_id','id');
            $table->foreign('accounts','account_id','id');

            $table->primary(['site_id','account_id']);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('site_accounts');

    }
}
