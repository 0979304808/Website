<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\Roles\CreateRoleRequest;
use App\Repositories\Roles\Contract\RoleRepositoryInterface;
use JavaScript;
class RoleController extends ApiController
{
    private $model;
    private $role;
    private $permission;

    public function __construct(RoleRepositoryInterface $role)
    {
        $this->model = $role;
    }

    // List Permission and Role
    public function list(){
        $roles = $this->model->WithPermissions();
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

    // Create Role
    public function create(CreateRoleRequest $request){
        $role = $this->model->firstOrCreate($request->except('_token'));
        return redirect()->back();
    }
    // Delete Role
    public function delete(){
        $id = request('id');
        $role = $this->model->findOneOrFail($id);
        if($role->delete()){
            return $this->success('Deleted');
        }
    }

    // Add Permission To Role
    public function addPermissionToRole(Request $request){
        $role =  $this->model->findOneOrFail($request->id);
        $permissions = $request->permissions;
        if($role){
            (!empty($permissions)) ? $role->syncPermissions($permissions) : $role->detachPermissions();
            return $this->success('Success');
        }
        return $this->error('Error sync permission', 400);
    }


}
