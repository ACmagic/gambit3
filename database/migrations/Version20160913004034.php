<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160913004034 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('sale_items', function(Table $table) {

            // Workflow state
            $table->unsignedBigInteger('state_id')->setNotnull(true);

            // Bind to sale item workflow state.
            $table->foreign('sale_item_workflow_states','state_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('sale_items', function(Table $table) {

            $table->dropColumn('state_id');

        });

    }
}
