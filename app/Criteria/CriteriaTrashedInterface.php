<?php
namespace Editora\Criteria;


interface CriteriaTrashedInterface
{
    public function onlyTrashed();
    public function withTrashed();
}