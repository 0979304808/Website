<?php

namespace App\Repositories\Posts\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function WithAll();

    public function createOrUpdate(array $attribute);

    public function WhereHasCategory($id);

    public function WhereHasTag($id);

    public function WhereHasCategoryTag($category, $tag);
}