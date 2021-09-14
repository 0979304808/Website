<?php

namespace App\Repositories\Admins\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;
use App\Models\Admins\Admin;

interface AdminRepositoryInterface extends BaseRepositoryInterface
{

    public function updateImage($file,Admin $admin);

    public function WithRolePermissions();
}
