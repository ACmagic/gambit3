<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160415013651 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        (new Builder($schema))->create('sale_advertised_lines', function(Table $table) {

            $table->unsignedBigInteger('id');

            // Numbers of line instances available.
            $table->integer('inventory')->setUnsigned(true)->setNotnull(true)->setDefault(1);

            // Amount
            $table->decimal('amount',19,4)->setUnsigned(true)->setNotnull(true);
            $table->decimal('amount_max',19,4)->setUnsigned(true)->setNotnull(false);

            $table->foreign('sale_items','id','id',['onDelete'=>'CASCADE']);
            $table->primary('id');

        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('sale_advertised_lines');
    }
}
