<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160927220111 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('sale_accepted_lines', function(Table $table) {

            $table->unsignedBigInteger('accepted_line_id')->setNotnull(false);
            $table->foreign('accepted_lines','accepted_line_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('sale_accepted_lines', function(Table $table) {

            $table->dropColumn('accepted_line_id');

        });

    }
}
