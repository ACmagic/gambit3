<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20170910195753 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->create('oauth_auth_codes', function(Table $table) {
            $table->increments('id');
            $table->string('email',128);
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();
            $table->unique('email');
        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->drop('oauth_auth_codes');
    }
}
