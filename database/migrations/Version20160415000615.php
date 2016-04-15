<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160415000615 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('asset_types', function(Table $table) {

            $table->smallIncrements('id');
            $table->string('machine_name',128)->setNotNull(true)->setDefault('');
            $table->string('human_name',128)->setNotNull(true)->setDefault('');
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
        (new Builder($schema))->drop('asset_types');
    }
}
