<?php

namespace App\Repositories\Codes\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface CodeRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $code
     * @return Collection
     */
    public function withAll();

    public function WhereStatusSort($status, $sort);

    public function search($search);
}