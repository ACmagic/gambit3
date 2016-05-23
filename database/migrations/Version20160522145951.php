<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160522145951 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('workflows', function(Table $table) {

            $table->bigIncrements('id')->setUnsigned(true);

            $table->string('machine_name',128)->setNotnull(true)->setDefault('');
            $table->string('human_name',128)->setNotnull(true)->setDefault('');

            $table->string('type',128)->setNotnull(true);

            $table->timestamps();

            $table->unique('machine_name');
            $table->unique('human_name');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('workflows');

    }
}
