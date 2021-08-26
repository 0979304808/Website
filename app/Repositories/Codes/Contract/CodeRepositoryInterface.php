<?php

namespace App\Repositories\Codes\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface CodeRepositoryInterface extends BaseRepositoryInterface {
    
    public function findCode($code);
}