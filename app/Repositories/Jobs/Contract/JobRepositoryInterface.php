<?php

namespace App\Repositories\Jobs\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface JobRepositoryInterface extends BaseRepositoryInterface {
    public function active_Job(array $list_id);
    
}