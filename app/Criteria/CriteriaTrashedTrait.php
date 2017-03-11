<?php

namespace Editora\Criteria;


trait CriteriaTrashedTrait
{
    public function onlyTrashed()
    {
        $this->pushCriteria(FindOnlyTrashedCriteria::class);
        return $this;
    }

    public function withTrashed()
    {
        $this->pushCriteria(FindPermissionsResourceCriteria::class);
        return $this;
    }
}