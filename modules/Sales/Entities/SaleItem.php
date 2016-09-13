<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

abstract class SaleItem {

    protected $id;
    protected $sale;
    protected $createdAt;
    protected $updatedAt;
    protected $state;
    protected $transitions;

    public function __construct() {
        $this->transitions = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setSale(Sale $sale) {
        $this->sale = $sale;
    }

    public function getSale() : Sale {
        return $this->sale;
    }

    public function setState(SaleItemWorkflowState $state) {
        $this->state = $state;
    }

    public function getState() : SaleItemWorkflowState {
        return $this->state;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function addTransition(SaleItemWorkflowTransition $transition) {
        $this->transitions[] = $transition;
    }

    /**
     * Calculate the cost of this line item.
     *
     * @return double
     */
    abstract public function calculateCost();

    /**
     * Determine whether item can be paid for via credits.
     *
     * @return bool
     */
    abstract public function isPayableViaCredits();

}