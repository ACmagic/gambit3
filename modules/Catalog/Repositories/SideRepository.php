<?php namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Side;

interface SideRepository {

    public function findById($id);
    public function findAll();

    /**
     * Get the seeker side.
     *
     * @return Side
     */
    public function getSeeker();

    /**
     * Get the house side.
     *
     * @return Side
     */
    public function getHouse();

}