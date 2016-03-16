<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160316000946 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('events', function(Table $table) {

            $table->bigIncrements('id')->setUnsigned(true);
            $table->integer('creator_id')->setUnsigned(true)->setNotnull(true);
            $table->string('display_title',128)->setNotnull(true);
            $table->timestamp('starts_at')->setNotnull(true);

            $table->timestamps();

            $table->foreign('users','creator_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('events');

    }
}
