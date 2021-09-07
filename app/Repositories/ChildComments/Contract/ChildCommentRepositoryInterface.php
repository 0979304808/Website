<?php

namespace App\Repositories\ChildComments\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface ChildCommentRepositoryInterface extends BaseRepositoryInterface
{
    public function withAll();
    public function whereLangStatus($lang, $status);
    public function createOrUpdateChildComment(array $attribute);
}