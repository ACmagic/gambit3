<?php namespace Modules\Sales\Repositories\Doctrine;

use Modules\Sales\Repositories\QuoteRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineQuoteRepository implements QuoteRepository {

    protected $genericRepository;

    public function __construct(ObjectRepository $genericRepository) {
        $this->genericRepository = $genericRepository;
    }

    public function findById($id) {
        return $this->genericRepository->find($id);
    }

    public function findAll() {
        return $this->genericRepository->findAll();
    }

    public function findBySessionIdAndSiteId($sessionId,$siteId) {
        // Only finds the quote that is a cart.
        return $this->genericRepository->findOneBy(['sessionId'=> $sessionId,'site'=>$siteId,'isCart'=>1]);
    }

}