<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20161011080811 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('event_categories', function(Table $table) {

            $table->bigInteger('event_id')->setUnsigned(true)->setNotnull(true);
            $table->bigInteger('category_id')->setUnsigned(true)->setNotnull(true);

            $table->foreign('events','event_id','id');
            $table->foreign('categories','category_id','id');

            $table->primary(['event_id','category_id']);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('event_categories');

    }
}
