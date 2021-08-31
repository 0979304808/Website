<?php

namespace App\Http\Controllers\Backend\Admins;

use App\Core\Traits\ApiResponser;
use App\Core\Traits\Authorization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Repositories\Admins\Contract\AdminRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    use ApiResponser;
    use Authorization;

    private $admin;

    public function __construct(AdminRepositoryInterface $admin)
    {
        $this->admin = $admin;
    }

    // Update user
    public function updateProfile(Request $request, $id)
    {
        if (Auth::id() == $id){
            $admin = $this->admin->find($id);
            $attributes = $request->only('username', 'password');
            if (!empty($attributes)) {
                $guard = $this->guard()->user();
                $guard->update($attributes);
                return redirect()->back()->with('success', 'Thành công');
            }
            return redirect()->back()->with('errors', 'Update không thành công');
        }
        return $this->error('Không có quyền truy cập',401);

    }

    // Update Image
    public function updateImage(ImageRequest $request, $id)
    {
        if (Auth::id() == $id) {
            if ($request->hasFile('image')) {
                $this->admin->updateImage($request->file('image'), $id);
            }
            return redirect()->back();
        }
        return $this->error('Không có quyền truy cập',401);
    }

    // Show user
    public function profile($id)
    {
        if (Auth::id() == $id) {
            $admin = $this->admin->find($id);
            $view = view('backend.admins.profile');
            $view->with('admin', $admin);
            return $view;
        }
        return $this->error('Không có quyền truy cập',401);
    }
}
