<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160522223104 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('workflow_transitions', function(Table $table) {

            $table->bigIncrements('id')->setUnsigned(true);

            $table->unsignedBigInteger('before_state_id')->setNotnull(false);
            $table->unsignedBigInteger('after_state_id')->setNotnull(true);

            $table->string('type',128)->setNotnull(true);

            $table->timestamps();

            $table->foreign('workflow_states','before_state_id','id');
            $table->foreign('workflow_states','after_state_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('workflow_transitions');
    }
}
