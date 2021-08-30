<?php

namespace App\Repositories\Profile\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface ProfileRepositoryInterface extends BaseRepositoryInterface
{

    public function uploadImage($file);
}