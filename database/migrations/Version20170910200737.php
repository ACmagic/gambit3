<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20170910200737 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        (new Builder($schema))->create('oauth_access_tokens', function(Table $table) {
            $table->string('id', 100);
            $table->integer('user_id')->setNotnull(false);
            $table->integer('client_id');
            $table->string('name')->setNotnull(false);
            $table->text('scopes')->setNotnull(false);
            $table->boolean('revoked');
            $table->timestamps();
            $table->dateTime('expires_at')->setNotnull(false);

            $table->primary('id');
            $table->index('user_id');

        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('oauth_access_tokens');
    }
}
