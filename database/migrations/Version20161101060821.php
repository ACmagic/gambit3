<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20161101060821 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('accepted_line_payouts', function(Table $table) {

            $table->bigInteger('posting_id')->setUnsigned(true)->setNotnull(true);
            $table->bigInteger('accepted_line_id')->setUnsigned(true)->setNotnull(true);

            $table->foreign('accepted_lines','accepted_line_id','id');
            $table->foreign('postings','posting_id','id');

            $table->primary(['posting_id']);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->drop('accepted_line_payouts');

    }
}
