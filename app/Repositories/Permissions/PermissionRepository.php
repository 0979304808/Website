<?php

namespace App\Repositories\Permissions;

use App\Core\Repositories\BaseRepository;
use App\Models\Permissions\Permission;
use App\Repositories\Permissions\Contract\PermissionRepositoryInterface;
use App\Core\Traits\ApiResponser;
use App\Core\Traits\Authorization;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface {
    use ApiResponser;
    use Authorization;
    protected $model;

    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
        $this->model = $permission;
    }

}