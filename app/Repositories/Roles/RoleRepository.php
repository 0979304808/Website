<?php

namespace App\Repositories\Roles;

use App\Core\Repositories\BaseRepository;
use App\Repositories\Roles\Contract\RoleRepositoryInterface;
use App\Core\Traits\ApiResponser;
use App\Core\Traits\Authorization;
use App\Models\Roles\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    use ApiResponser;
    use Authorization;
    protected $model;

    public function __construct(Role $role)
    {
        parent::__construct($role);
        $this->model = $role;
    }

    public function WithPermissions()
    {
        return $this->model->with('permissions')->latest()->paginate();
    }
}