<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Permission;
use App\Role;
use JavaScript;
use App\Repositories\Admins\Contract\AdminRepositoryInterface;

class AccountController extends ApiController
{
    private $model;

    public function __construct(AdminRepositoryInterface $admin)
    {
        $this->model = $admin;
    }

    // List Admin, Role, Permissions
    public function list(Request $request){
        $accounts = $this->model->WithRolePermissions();
        $roles = Role::all();
        $permissions = Permission::all();
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
    public function updateRoleAdmin(){
        $admin = $this->model->findOneOrFail(request('id'));
        $roles = request('roles');
        if(!empty($roles)){
            $admin->syncRoles($roles);
            $admin->syncPermissions($admin->getPermissionsViaRoles());
        }else{
            $permissionsInRoles = $admin->getPermissionsViaRoles();
            $admin->detachRoles();
            $admin->detachPermissions($permissionsInRoles);
        }

        return $this->success('Success');
    }
    
    // Update Permission To Admin
    public function updatePermissionAdmin(){
        $admin = $this->model->findOneOrFail(request('id'));
        $permissions = request('permissions');
        if(!empty($permissions)){
            $admin->syncPermissions($permissions);
        }else{
            $admin->detachPermissions();
        }

        return $this->success('Success');
    }

    // Active User
    public function active(){
        $id = request('id');
        $active = request('active', false);
        $admin = $this->model->find($id)->update(['active' => $active]);
        if($admin){
            return $this->success('Success');
        }
        return $this->error('Cannot updated', 400);
    }

}
