<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Admin;
use App\Http\Controllers\Api\ApiController;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use JavaScript;

class AccountController extends ApiController
{
    const _limit = 20;

    private $admin;

    public function updateRoleAdmin(){
        $admin = Admin::findOrFail(request('id'));
        $roles = request('roles');
        if(!empty($roles)){
            // sync role and permissions
            $admin->syncRoles($roles);
            $admin->syncPermissions($admin->getPermissionsViaRoles());
        }else{
            $permissionsInRoles = $admin->getPermissionsViaRoles();
            $admin->detachRoles();
            $admin->detachPermissions($permissionsInRoles);
        }

        return $this->success('Success');
    }

    public function updatePermissionAdmin(){
        $admin = Admin::findOrFail(request('id'));
        $permissions = request('permissions');
        if(!empty($permissions)){
            // sync role and permissions
            $admin->syncPermissions($permissions);
        }else{
            $admin->detachPermissions();
        }

        return $this->success('Success');
    }

    public function active(){
        $id = request('id');
        $active = request('active', false);
        $admin = Admin::find($id)->update(['active' => $active]);
        if($admin){
            return $this->success('Success');
        }
        return $this->error('Cannot updated', 400);
    }

    public function list(Request $request){
        $accounts = Admin::with(['roles', 'permissions'])->latest()->paginate(self::_limit, ['id', 'username', 'email', 'image', 'active']);
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
}
