<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160501183003 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        (new Builder($schema))->table('quotes', function(Table $table) {
            
            $table->getTable()->changeColumn('is_cart',[
                'notnull'=> false,
                'default'=> null,
            ]);
            $table->getTable()->dropIndex('UNIQ_A1B588C5F6BD1646613FECDF');
            $table->unique(['site_id','session_id','is_cart']);

        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        (new Builder($schema))->table('quotes', function(Table $table) {

            $table->getTable()->changeColumn('is_cart',[
                'notnull'=> true,
                'default'=> 1,
            ]);

            $table->boolean('is_cart')->setDefault(1)->setNotnull(true);
            $table->getTable()->dropIndex('UNIQ_A1B588C5F6BD1646613FECDF9E50A696');
            $table->unique(['site_id','session_id']);

        });

    }
}
