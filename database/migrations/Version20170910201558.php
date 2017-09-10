<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20170910201558 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        (new Builder($schema))->create('oauth_refresh_tokens', function(Table $table) {
            $table->string('id', 100);
            $table->string('access_token_id', 100);
            $table->boolean('revoked');
            $table->dateTime('expires_at')->setNotnull(false);

            $table->primary('id');
            $table->index('access_token_id');

        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('oauth_refresh_tokens');
    }
}
