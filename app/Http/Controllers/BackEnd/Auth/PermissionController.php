<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Repositories\Permissions\Contract\PermissionRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\CreatePermissionRequest;

class PermissionController extends Controller
{
    private $permission;

    public function __construct(PermissionRepositoryInterface $permission)
    {
        $this->permission = $permission;
    }

    // Create Permission
    public function create(CreatePermissionRequest $request)
    {
        $this->permission->firstOrCreate($request->except('_token'));
        return redirect()->back();
    }
}
