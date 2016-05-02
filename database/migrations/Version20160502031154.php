<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160502031154 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('sale_transactions', function(Table $table) {

            $table->bigInteger('posting_id')->setUnsigned(true)->setNotnull(true);
            $table->bigInteger('sale_id')->setUnsigned(true)->setNotnull(true);

            $table->foreign('sales','sale_id','id');
            $table->foreign('postings','posting_id','id');

            $table->primary(['posting_id']);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('sale_transactions');

    }
}
