<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160915034849 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        (new Builder($schema))->create('line_workflow_states', function(Table $table) {

            $table->unsignedBigInteger('id');
            $table->foreign('workflow_states','id','id',['onDelete'=>'CASCADE']);
            $table->primary('id');

        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('line_workflow_states');
    }
}
