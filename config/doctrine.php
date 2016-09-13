<?php

use Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql as SyslogicFuncs;

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
                'Modules\Accounting\Entities',
                'Modules\Catalog\Entities',
                'Modules\Prediction\Entities',
                'Modules\Event\Entities',
                'Modules\Vegas\Entities',
                'Modules\Sports\Entities',
                'Modules\Football\Entities',
                'Modules\Sales\Entities',
                'Modules\Workflow\Entities',
            ],
            'paths'      => [
                // Significant performance boost (minimal scanning)
                base_path('modules/Core/Mappings'),
                base_path('modules/Customer/Mappings'),
                base_path('modules/Accounting/Mappings'),
                base_path('modules/Catalog/Mappings'),
                base_path('modules/Prediction/Mappings'),
                base_path('modules/Event/Mappings'),
                base_path('modules/Vegas/Mappings'),
                base_path('modules/Sports/Mappings'),
                base_path('modules/Football/Mappings'),
                base_path('modules/Sales/Mappings'),
                base_path('modules/Workflow/Mappings'),
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
                'subscribers' => [
                    /*Doctrine\DBAL\Events::onSchemaDropTable => Modules\Core\Subscribers\DoctrineSubscriber::class*/

                    // Core
                    Modules\Core\Subscribers\DoctrineSubscriber::class,

                    // Accounting
                    Modules\Accounting\Subscribers\DoctrineSubscriber::class,

                    // Catalog
                    Modules\Catalog\Subscribers\DoctrineSubscriber::class,

                    // Sales
                    Modules\Sales\Subscribers\DoctrineSubscriber::class,

                ]
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
                //'datetime'=> 'carbondatetime',
                //'date'=> 'carbondate',
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

                // Accounting
                Modules\Accounting\Mappings\AccountTypeMapping::class,
                Modules\Accounting\Mappings\AssetTypeMapping::class,
                Modules\Accounting\Mappings\PostingEventMapping::class,
                Modules\Accounting\Mappings\AccountMapping::class,
                Modules\Accounting\Mappings\PostingMapping::class,

                // Catalog
                Modules\Catalog\Mappings\SideMapping::class,
                Modules\Catalog\Mappings\LineMapping::class,
                Modules\Catalog\Mappings\InverseLineMapping::class,
                Modules\Catalog\Mappings\AdvertisedLineMapping::class,
                Modules\Catalog\Mappings\AcceptedLineMapping::class,

                // Prediction
                Modules\Prediction\Mappings\PredictionMapping::class,
                Modules\Prediction\Mappings\InversePredictionMapping::class,

                // Event
                Modules\Event\Mappings\CategoryMapping::class,
                Modules\Event\Mappings\EventMapping::class,
                Modules\Event\Mappings\CompetitorMapping::class,

                // Vegas
                Modules\Vegas\Mappings\MoneyLineMapping::class,
                Modules\Vegas\Mappings\PointSpreadMapping::class,
                Modules\Vegas\Mappings\InverseMoneyLineMapping::class,
                Modules\Vegas\Mappings\InversePointSpreadMapping::class,

                // Sports
                Modules\Sports\Mappings\GameMapping::class,
                Modules\Sports\Mappings\TeamMapping::class,
                Modules\Sports\Mappings\PlayerMapping::class,

                // Football
                Modules\Football\Mappings\NFLGameMapping::class,
                Modules\Football\Mappings\NFLTeamMapping::class,

                // Sales
                Modules\Sales\Mappings\QuoteMapping::class,
                Modules\Sales\Mappings\QuoteItemMapping::class,
                Modules\Sales\Mappings\QuoteAdvertisedLineMapping::class,
                Modules\Sales\Mappings\QuoteAcceptedLineMapping::class,
                Modules\Sales\Mappings\QuoteCreditMapping::class,
                Modules\Sales\Mappings\QuotePredictionMapping::class,
                Modules\Sales\Mappings\QuoteMoneyLineMapping::class,
                Modules\Sales\Mappings\QuotePointSpreadMapping::class,

                Modules\Sales\Mappings\SaleMapping::class,
                Modules\Sales\Mappings\SaleItemMapping::class,
                Modules\Sales\Mappings\SaleAdvertisedLineMapping::class,
                Modules\Sales\Mappings\SaleAcceptedLineMapping::class,
                Modules\Sales\Mappings\SaleCreditMapping::class,
                Modules\Sales\Mappings\SalePredictionMapping::class,
                Modules\Sales\Mappings\SaleMoneyLineMapping::class,
                Modules\Sales\Mappings\SalePointSpreadMapping::class,

                Modules\Sales\Mappings\SaleWorkflowMapping::class,
                Modules\Sales\Mappings\SaleWorkflowStateMapping::class,
                Modules\Sales\Mappings\SaleWorkflowTransitionMapping::class,

                Modules\Sales\Mappings\SaleItemWorkflowMapping::class,
                Modules\Sales\Mappings\SaleItemWorkflowStateMapping::class,
                Modules\Sales\Mappings\SaleItemWorkflowTransitionMapping::class,

                // Workflow
                Modules\Workflow\Mappings\WorkflowMapping::class,
                Modules\Workflow\Mappings\StateMapping::class,
                Modules\Workflow\Mappings\TransitionMapping::class,

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
        'CHAR_LENGTH'                                       => DoctrineExtensions\Query\Mysql\CharLength::class,
        'CONCAT_WS'                                         => DoctrineExtensions\Query\Mysql\ConcatWs::class,
        'FIELD'                                             => DoctrineExtensions\Query\Mysql\Field::class,
        'FIND_IN_SET'                                       => DoctrineExtensions\Query\Mysql\FindInSet::class,
        'REPLACE'                                           => DoctrineExtensions\Query\Mysql\Replace::class,
        'SOUNDEX'                                           => DoctrineExtensions\Query\Mysql\Soundex::class,
        'STR_TO_DATE'                                       => DoctrineExtensions\Query\Mysql\StrToDate::class,

        // MySQL Native JSON Functions
        SyslogicFuncs\JsonContains::FUNCTION_NAME           => SyslogicFuncs\JsonContains::class,
        SyslogicFuncs\JsonContainsPath::FUNCTION_NAME       => SyslogicFuncs\JsonContainsPath::class,

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
