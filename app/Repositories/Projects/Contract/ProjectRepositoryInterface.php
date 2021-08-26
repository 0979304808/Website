<?php

namespace App\Repositories\Projects\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface ProjectRepositoryInterface extends BaseRepositoryInterface {
    
    public function findSlug(string $slug);
    
}