<?php

namespace App\Repositories\Codes\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface CodePurchaseRepositoryInterface extends BaseRepositoryInterface {
    public function WithAdmin($code);
}