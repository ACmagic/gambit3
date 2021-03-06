<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160322012627 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('quote_predictions', function(Table $table) {

            $table->bigIncrements('id')->setUnsigned(true);
            $table->unsignedBigInteger('advertised_line_id')->setNotnull(true);
            $table->string('type',128)->setNotnull(true);
            $table->timestamps();
            $table->foreign('quote_advertised_lines','advertised_line_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('quote_predictions');
    }
}
