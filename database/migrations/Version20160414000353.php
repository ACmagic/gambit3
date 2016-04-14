<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160414000353 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('accounts', function(Table $table) {

            $table->bigIncrements('id');

            // Account type.
            $table->smallInteger('type_id')->setUnsigned(true)->setNotnull(true);

            // Balance
            $table->decimal('balance',19,4)->setUnsigned(false)->setNotnull(true)->setDefault(0);

            $table->timestamps();

            $table->foreign('account_types','type_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('accounts');
    }
}
