<?php namespace Modules\Core\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Events;
use Doctrine\DBAL\Event\SchemaDropTableEventArgs;

class DoctrineSubscriber implements EventSubscriber {

    public function getSubscribedEvents() {

        return [
            Events::onSchemaDropTable
        ];

    }

    /**
     * This is a work-around for dropping tables that are reserved words since
     * the default implementation does not do so, resulting in an MySQL error.
     */
    public function onSchemaDropTable(SchemaDropTableEventArgs $args) {

        $table = $args->getTable();
        $reserved = ['lines'];

        if(in_array($table,$reserved)) {
            $sql = sprintf('DROP TABLE `%s`',$table);
            $args->setSql($sql);
            $args->preventDefault();
        }

    }

}