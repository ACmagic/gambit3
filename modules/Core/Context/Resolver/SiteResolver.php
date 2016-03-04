<?php namespace Modules\Core\Context\Resolver;

use Modules\Core\Context\Resolver;
use Modules\Core\Context\Type\SiteContext;
use Modules\Core\Repositories\SiteRepository;

class SiteResolver implements Resolver {

    protected $siteRepository;

    public function __construct(SiteRepository $siteRepository) {
        $this->siteRepository = $siteRepository;
    }

    public function getName() {
        return 'site_resolver';
    }

    public function resolves($contextType) {
        return $contextType == 'site';
    }

    public function resolve() {

        $site = $this->siteRepository->findById(1);
        $context = new SiteContext($site);

        return $context;

    }

}