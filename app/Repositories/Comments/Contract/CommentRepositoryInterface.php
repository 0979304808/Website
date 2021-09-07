<?php

namespace App\Repositories\Comments\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface CommentRepositoryInterface extends BaseRepositoryInterface
{
    public function withAll();

    public function whereLangStatus($lang, $status);
    public function createOrUpdateComment(array $attribute);
}