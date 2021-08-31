<?php

namespace App\Repositories\Jlpt\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface JlptRepositoryInterface extends BaseRepositoryInterface
{
    public function WithAll();

    public function search($search);

    public function createOrUpdate(array $attribute);

    public function deleteJplt($id);
}