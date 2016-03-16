<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Entity Mangers
    |--------------------------------------------------------------------------
    |
    | Configure your Entity Managers here. You can set a different connection
    | and driver per manager and configure events and filters. Change the
    | paths setting to the appropriate path and replace App namespace
    | by your own namespace.
    |
    | Available meta drivers: fluent|annotations|yaml|xml|config|static_php
    |
    | Available connections: mysql|oracle|pgsql|sqlite|sqlsrv
    | (Connections can be configured in the database config)
    |
    | --> Warning: Proxy auto generation should only be enabled in dev!
    |
    */
    'managers'                  => [
        'default' => [
            'dev'        => env('APP_DEBUG'),
            'meta'       => 'fluent',
            'connection' => env('DB_CONNECTION', 'mysql'),
            'namespaces' => [
                // Significant performance boost (minimal scanning)
                'Modules\Core\Entities',
                'Modules\Customer\Entities',
                'Modules\Catalog\Entities',
                'Modules\Event\Entities',
                'Modules\Sports\Entities',
            ],
            'paths'      => [
                // Significant performance boost (minimal scanning)
                base_path('modules/Core/Mappings'),
                base_path('modules/Customer/Mappings'),
                base_path('modules/Catalog/Mappings'),
                base_path('modules/Event/Mappings'),
                base_path('modules/Sports/Mappings'),
            ],
            'repository' => Doctrine\ORM\EntityRepository::class,
            'proxies'    => [
                'namespace'     => false,
                'path'          => storage_path('proxies'),
                'auto_generate' => env('DOCTRINE_PROXY_AUTOGENERATE', false)
            ],
            /*
            |--------------------------------------------------------------------------
            | Doctrine events
            |--------------------------------------------------------------------------
            |
            | The listener array expects the key to be a Doctrine event
            | e.g. Doctrine\ORM\Events::onFlush
            |
            */
            'events'     => [
                'listeners'   => [],
                'subscribers' => []
            ],
            'filters'    => [],
            /*
            |--------------------------------------------------------------------------
            | Doctrine mapping types
            |--------------------------------------------------------------------------
            |
            | Link a Database Type to a Local Doctrine Type
            |
            | Using 'enum' => 'string' is the same of:
            | $doctrineManager->extendAll(function (\Doctrine\ORM\Configuration $configuration,
            |         \Doctrine\DBAL\Connection $connection,
            |         \Doctrine\Common\EventManager $eventManager) {
            |     $connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            | });
            |
            | References:
            | http://doctrine-orm.readthedocs.org/en/latest/cookbook/custom-mapping-types.html
            | http://doctrine-dbal.readthedocs.org/en/latest/reference/types.html#custom-mapping-types
            | http://doctrine-orm.readthedocs.org/en/latest/cookbook/advanced-field-value-conversion-using-custom-mapping-types.html
            | http://doctrine-orm.readthedocs.org/en/latest/reference/basic-mapping.html#reference-mapping-types
            | http://symfony.com/doc/current/cookbook/doctrine/dbal.html#registering-custom-mapping-types-in-the-schematool
            |--------------------------------------------------------------------------
            */
            'mapping_types' => [
                //'enum' => 'string'
            ],
            /*
             * Fluent mappings.
             */
            'mappings'=> [
                // Core
                Modules\Core\Mappings\UserMapping::class,
                Modules\Core\Mappings\SiteMapping::class,
                Modules\Core\Mappings\StoreMapping::class,

                // Customer
                Modules\Customer\Mappings\CustomerMapping::class,
                Modules\Customer\Mappings\CustomerPoolMapping::class,

                // Catalog
                Modules\Catalog\Mappings\SideMapping::class,
                Modules\Catalog\Mappings\LineMapping::class,
                Modules\Catalog\Mappings\AdvertisedLineMapping::class,
                Modules\Catalog\Mappings\AcceptedLineMapping::class,

                // Event
                Modules\Event\Mappings\CategoryMapping::class,
                Modules\Event\Mappings\EventMapping::class,

                // Sports
                Modules\Sports\Mappings\GameMapping::class
            ],
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | Doctrine Extensions
    |--------------------------------------------------------------------------
    |
    | Enable/disable Doctrine Extensions by adding or removing them from the list
    |
    | If you want to require custom extensions you will have to require
    | laravel-doctrine/extensions in your composer.json
    |
    */
    'extensions'                => [
        //LaravelDoctrine\ORM\Extensions\TablePrefix\TablePrefixExtension::class,
        //LaravelDoctrine\Extensions\Timestamps\TimestampableExtension::class,
        //LaravelDoctrine\Extensions\SoftDeletes\SoftDeleteableExtension::class,
        //LaravelDoctrine\Extensions\Sluggable\SluggableExtension::class,
        //LaravelDoctrine\Extensions\Sortable\SortableExtension::class,
        LaravelDoctrine\Extensions\Tree\TreeExtension::class,
        //LaravelDoctrine\Extensions\Loggable\LoggableExtension::class,
        //LaravelDoctrine\Extensions\Blameable\BlameableExtension::class,
        //LaravelDoctrine\Extensions\IpTraceable\IpTraceableExtension::class,
        //LaravelDoctrine\Extensions\Translatable\TranslatableExtension::class
    ],
    /*
    |--------------------------------------------------------------------------
    | Doctrine custom types
    |--------------------------------------------------------------------------
    |
    | Create a custom or override a Doctrine Type
    |--------------------------------------------------------------------------
    */
    'custom_types'              => [
        'json' => LaravelDoctrine\ORM\Types\Json::class,
        'carbondate'       => DoctrineExtensions\Types\CarbonDateType::class,
        'carbondatetime'   => DoctrineExtensions\Types\CarbonDateTimeType::class,
        'carbondatetimetz' => DoctrineExtensions\Types\CarbonDateTimeTzType::class,
        'carbontime'       => DoctrineExtensions\Types\CarbonTimeType::class,
    ],
    /*
    |--------------------------------------------------------------------------
    | DQL custom datetime functions
    |--------------------------------------------------------------------------
    */
    'custom_datetime_functions' => [
        'DATEADD'  => DoctrineExtensions\Query\Mysql\DateAdd::class,
        'DATEDIFF' => DoctrineExtensions\Query\Mysql\DateDiff::class,
    ],
    /*
    |--------------------------------------------------------------------------
    | DQL custom numeric functions
    |--------------------------------------------------------------------------
    */
    'custom_numeric_functions'  => [
        'ACOS'    => DoctrineExtensions\Query\Mysql\Acos::class,
        'ASIN'    => DoctrineExtensions\Query\Mysql\Asin::class,
        'ATAN'    => DoctrineExtensions\Query\Mysql\Atan::class,
        'ATAN2'   => DoctrineExtensions\Query\Mysql\Atan2::class,
        'COS'     => DoctrineExtensions\Query\Mysql\Cos::class,
        'COT'     => DoctrineExtensions\Query\Mysql\Cot::class,
        'DEGREES' => DoctrineExtensions\Query\Mysql\Degrees::class,
        'RADIANS' => DoctrineExtensions\Query\Mysql\Radians::class,
        'SIN'     => DoctrineExtensions\Query\Mysql\Sin::class,
        'TAN'     => DoctrineExtensions\Query\Mysql\Tan::class
    ],
    /*
    |--------------------------------------------------------------------------
    | DQL custom string functions
    |--------------------------------------------------------------------------
    */
    'custom_string_functions'   => [
        'CHAR_LENGTH' => DoctrineExtensions\Query\Mysql\CharLength::class,
        'CONCAT_WS'   => DoctrineExtensions\Query\Mysql\ConcatWs::class,
        'FIELD'       => DoctrineExtensions\Query\Mysql\Field::class,
        'FIND_IN_SET' => DoctrineExtensions\Query\Mysql\FindInSet::class,
        'REPLACE'     => DoctrineExtensions\Query\Mysql\Replace::class,
        'SOUNDEX'     => DoctrineExtensions\Query\Mysql\Soundex::class,
        'STR_TO_DATE' => DoctrineExtensions\Query\Mysql\StrToDate::class,
    ],
    /*
    |--------------------------------------------------------------------------
    | Enable query logging with laravel file logging,
    | debugbar, clockwork or an own implementation.
    | Setting it to false, will disable logging
    |
    | Available:
    | - LaravelDoctrine\ORM\Loggers\LaravelDebugbarLogger
    | - LaravelDoctrine\ORM\Loggers\ClockworkLogger
    | - LaravelDoctrine\ORM\Loggers\FileLogger
    |--------------------------------------------------------------------------
    */
    'logger'                    => env('DOCTRINE_LOGGER', false),
    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Configure meta-data, query and result caching here.
    | Optionally you can enable second level caching.
    |
    | Available: acp|array|file|memcached|redis|void
    |
    */
    'cache'                     => [
        'default'                => env('DOCTRINE_CACHE', 'array'),
        'namespace'              => null,
        'second_level'           => false,
    ],
    /*
    |--------------------------------------------------------------------------
    | Gedmo extensions
    |--------------------------------------------------------------------------
    |
    | Settings for Gedmo extensions
    | If you want to use this you will have to require
    | laravel-doctrine/extensions in your composer.json
    |
    */
    'gedmo'                     => [
        'all_mappings' => true,
    ]
];
