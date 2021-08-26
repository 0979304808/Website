<?php

namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\CreatePermissionRequest;
use App\Permission;

class PermissionController extends Controller
{
    

    // Create Permission
    public function create(CreatePermissionRequest $request){
        $permission = Permission::firstOrCreate($request->except('_token'));
        
        return redirect()->back();
    }
}
