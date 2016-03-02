<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160302010133 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('customer_pool', function(Table $table) {
            $table->increments('id');

            $table->integer('site_id')->setUnsigned(true)->setNotnull(true);

            $table->timestamps();

            $table->foreign('sites','site_id','id');

            // One pool per a site.
            $table->unique('site_id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('customer_pool');
    }
}
