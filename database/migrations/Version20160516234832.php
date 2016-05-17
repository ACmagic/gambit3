<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160516234832 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('quotes', function(Table $table) {

            // Expired
            $table->boolean('is_expired')->setDefault(0)->setNotnull(true);

            // Expired at
            $table->dateTime('expired_at')->setNotnull(false);

            // Associated sate
            $table->unsignedBigInteger('sale_id')->setNotnull(false);

            // Foreign key out
            $table->foreign('sales','sale_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('quotes', function(Table $table) {

            $table->dropColumn('is_expired');
            $table->dropColumn('expired_at');
            $table->dropColumn('sale_id');

        });

    }
}
