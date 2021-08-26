<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\Roles\CreateRoleRequest;
use JavaScript;
class RoleController extends ApiController
{
    private $role;
    private $permission;


    public function create(CreateRoleRequest $request){
        $role = Role::firstOrCreate($request->except('_token'));
        
        return redirect()->back();
    }

    public function delete(){
        $id = request('id');
        $role = Role::findOrFail($id);
        if($role->delete()){
            return $this->success('Deleted');
        }
        return $this->error('Cannot delete role', 400);
    }

    public function addPermissionToRole(Request $request){
        $role = Role::find($request->id);
        $permissions = $request->permissions;
        if($role){
            (!empty($permissions)) ? $role->syncPermissions($permissions) : $role->detachPermissions();
            return $this->success('Success');
        }
        return $this->error('Error sync permission', 400);
    }

    public function list(){
        $roles = Role::with('permissions')->latest()->paginate();
        $permissions = Permission::all();
        JavaScript::put([
            'roles' => $roles,
            'link_update_permission_role' => route('backend.role.add.permission'),
            'link_delete_role' => route('backend.role.delete')
        ]);

        $view = view('backend.auth.role');
        $view->with('roles', $roles);
        $view->with('permissions', $permissions);
        return $view;
    }
}
