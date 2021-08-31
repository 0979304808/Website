<?php

namespace App\Repositories\Profile\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface ProfileRepositoryInterface extends BaseRepositoryInterface
{

//    public function uploadImage($file);
    public function createOrUpdate(array $attribute, $id = null);
}