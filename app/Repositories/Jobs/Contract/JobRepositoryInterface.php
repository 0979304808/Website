<?php

namespace App\Repositories\Jobs\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface JobRepositoryInterface extends BaseRepositoryInterface
{
    public function withAll();
    public function whereAll($type, $active, $country, $province);
    public function Search($search);
    public function updateJob(array $attribute, $id);
}