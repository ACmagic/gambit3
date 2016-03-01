<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160301013515 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        (new Builder($schema))->create('stores', function(Table $table) {
            $table->increments('id');

            $table->integer('creator_id')->setUnsigned(true)->setNotnull(false);
            $table->integer('site_id')->setUnsigned(true)->setNotnull(true);

            $table->timestamps();

            $table->foreign('users','creator_id','id');
            $table->foreign('sites','site_id','id');
        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('stores');
    }
}
