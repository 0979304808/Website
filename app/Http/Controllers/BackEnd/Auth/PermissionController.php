<?php

namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\CreatePermissionRequest;
use App\Models\Admins\Permission;

class PermissionController extends Controller
{
    
    public function create(CreatePermissionRequest $request){
        $permission = Permission::firstOrCreate($request->except('_token'));
        
        return redirect()->back();
    }
}
