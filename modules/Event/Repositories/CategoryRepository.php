<?php namespace Modules\Event\Repositories;

use Gedmo\Tree\RepositoryInterface;

interface CategoryRepository extends RepositoryInterface {

    public function findById($id);
    public function findByMachineName($machineName);

}