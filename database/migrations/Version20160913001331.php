<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160913001331 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('sale_item_workflow_transitions', function(Table $table) {

            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('sale_item_id')->setNotnull(true);

            $table->foreign('workflow_transitions','id','id',['onDelete'=>'CASCADE']);
            $table->foreign('sale_items','sale_item_id','id');

            $table->primary('id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('sale_item_workflow_transitions');
    }
}
