<?php

namespace App\Repositories\Jlpt\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface JlptRepositoryInterface extends BaseRepositoryInterface {
    public function deletePost($id);

    public function updatePost($params,$id);
}