<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160311044726 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('categories', function(Table $table) {

            $table->dropColumn('root');
            $table->unsignedBigInteger('root_id')->setNotnull(false);
            $table->foreign('categories','root_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('categories', function(Table $table) {

            $table->dropColumn('root_id');
            $table->unsignedBigInteger('root')->setNotnull(false);

        });

    }
}
