<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160309013053 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('lines', function(Table $table) {
            $table->bigIncrements('id');

            $table->integer('store_id')->setUnsigned(true)->setNotnull(true);
            $table->smallInteger('side_id')->setUnsigned(true)->setNotnull(true);

            // Between -500 and 500
            $table->integer('odds')->setNotnull(true)->setDefault(0);

            $table->timestamps();

            $table->foreign('stores','store_id','id');
            $table->foreign('sides','side_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('lines');

    }
}
