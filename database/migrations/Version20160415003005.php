<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160415003005 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('postings', function(Table $table) {

            $table->bigIncrements('id')->setUnsigned(true);
            $table->unsignedBigInteger('account_id')->setNotnull(true);
            $table->unsignedSmallInteger('event_id')->setNotnull(true);
            $table->unsignedSmallInteger('asset_type_id')->setNotnull(true);
            $table->decimal('amount',19,4)->setUnsigned(false)->setNotnull(true);
            $table->timestamps();

            $table->foreign('accounts','account_id','id');
            $table->foreign('posting_events','event_id','id');
            $table->foreign('asset_types','asset_type_id','id');

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('postings');
    }
}
