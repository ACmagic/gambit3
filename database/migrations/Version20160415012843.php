<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160415012843 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('sale_accepted_lines', function(Table $table) {

            $table->unsignedBigInteger('id');
            $table->bigInteger('advertised_line_id')->setUnsigned(true)->setNotnull(true);
            $table->foreign('advertised_lines','advertised_line_id','id');
            $table->foreign('sale_items','id','id',['onDelete'=>'CASCADE']);
            $table->primary('id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('sale_accepted_lines');
    }
}
