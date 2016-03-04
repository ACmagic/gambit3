<?php namespace Modules\Core\Context\Type;

use Modules\Core\Context\Context;
use Modules\Core\Contracts\Context\Site as SiteContract;
use Modules\Core\Entities\Site as SiteEntity;

class SiteContext implements Context, SiteContract {

    protected $site;

    public function __construct(SiteEntity $site) {
        $this->site = $site;
    }

    public function getName() {
        return 'site';
    }

    public function getSiteId() {
        return $this->site->getId();
    }

}