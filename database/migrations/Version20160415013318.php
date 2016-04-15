<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160415013318 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('sale_credits', function(Table $table) {

            $table->unsignedBigInteger('id');

            // Amount
            $table->decimal('amount',19,4)->setUnsigned(true)->setNotnull(true);

            $table->foreign('sale_items','id','id',['onDelete'=>'CASCADE']);
            $table->primary('id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('sale_credits');
    }
}
