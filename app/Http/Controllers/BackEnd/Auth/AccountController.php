<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Repositories\Permissions\Contract\PermissionRepositoryInterface;
use App\Repositories\Roles\Contract\RoleRepositoryInterface;
use JavaScript;
use App\Repositories\Admins\Contract\AdminRepositoryInterface;

class AccountController extends ApiController
{
    private $admin;
    private $role;
    private $permission;

    public function __construct(AdminRepositoryInterface $admin, RoleRepositoryInterface $role, PermissionRepositoryInterface $permission)
    {
        $this->admin = $admin;
        $this->role = $role;
        $this->permission = $permission;
    }

    // List Admin, Role, Permissions
    public function list()
    {
        $accounts = $this->admin->WithRolePermissions();
        $roles = $this->role->all();
        $permissions = $this->permission->all();
        JavaScript::put([
            'data' => $accounts,
            'link_active' => route('backend.account.active'),
            'link_update_admin_role' => route('backend.account.update.role'),
            'link_update_admin_permission' => route('backend.account.update.permission')
        ]);

        $view = view('backend.accounts.index');
        $view->with('accounts', $accounts);
        $view->with('roles', $roles);
        $view->with('permissions', $permissions);
        return $view;
    }

    // Update Role To Admin
    public function updateRoleAdmin()
    {
        $admin = $this->admin->findOneOrFail(request('id'));
        $roles = request('roles');
        if (!empty($roles)) {
            $admin->syncRoles($roles);
            $admin->syncPermissions($admin->getPermissionsViaRoles());
        } else {
            $permissionsInRoles = $admin->getPermissionsViaRoles();
            $admin->detachRoles();
            $admin->detachPermissions($permissionsInRoles);
        }

        return $this->success('Success');
    }

    // Update Permission To Admin
    public function updatePermissionAdmin()
    {
        $admin = $this->admin->findOneOrFail(request('id'));
        $permissions = request('permissions');
        if (!empty($permissions)) {
            $admin->syncPermissions($permissions);
        } else {
            $admin->detachPermissions();
        }

        return $this->success('Success');
    }

    // Active User
    public function active()
    {
        $id = request('id');
        $active = request('active', false);
        $admin = $this->admin->find($id)->update(['active' => $active]);
        if ($admin) {
            return $this->success('Success');
        }
        return $this->error('Cannot updated', 400);
    }

}
