<?php

namespace App\Repositories\Premiums\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface PremiumMaziiRepositoryInterface extends BaseRepositoryInterface
{
    public function withAll();

    public function search($search);

    public function WhereSortFilter($sort, $filter);

}