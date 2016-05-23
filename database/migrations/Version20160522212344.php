<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160522212344 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('workflow_states', function(Table $table) {

            $table->bigIncrements('id')->setUnsigned(true);

            $table->unsignedBigInteger('workflow_id')->setNotnull(true);

            $table->string('machine_name',128)->setNotnull(true)->setDefault('');
            $table->string('human_name',128)->setNotnull(true)->setDefault('');

            $table->string('type',128)->setNotnull(true);

            $table->timestamps();

            $table->unique(['workflow_id','machine_name']);
            $table->unique(['workflow_id','human_name']);

            $table->foreign('workflows','workflow_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('workflow_states');
    }
}
