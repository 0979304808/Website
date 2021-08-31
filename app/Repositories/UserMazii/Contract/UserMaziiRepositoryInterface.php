<?php

namespace App\Repositories\UserMazii\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface UserMaziiRepositoryInterface extends BaseRepositoryInterface
{
    public function WithAll();
}