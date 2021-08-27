<?php

namespace App\Repositories\Posts\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface PostRepositoryInterface extends BaseRepositoryInterface {
    public function WithAll();
    public function createOrUpdate(array $attribute);
}