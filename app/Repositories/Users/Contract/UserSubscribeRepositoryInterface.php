<?php

namespace App\Repositories\Users\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface UserSubscribeRepositoryInterface extends BaseRepositoryInterface {

    public function WhereHasUser($search);
    public function WithUser();
}