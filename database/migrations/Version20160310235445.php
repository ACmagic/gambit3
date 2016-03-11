<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160310235445 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('categories', function(Table $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('lft')->setNotnull(true);
            $table->unsignedBigInteger('rgt')->setNotnull(true);
            $table->unsignedBigInteger('lvl')->setNotnull(true);
            $table->unsignedBigInteger('root')->setNotnull(false);

            $table->integer('creator_id')->setUnsigned(true)->setNotnull(false);

            $table->string('machine_name',128)->setNotNull(true)->setDefault('');
            $table->string('human_name',128)->setNotNull(true)->setDefault('');

            $table->timestamps();

            $table->foreign('users','creator_id','id');
        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('categories');
    }
}
