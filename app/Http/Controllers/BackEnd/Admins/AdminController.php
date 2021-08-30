<?php

namespace App\Http\Controllers\Backend\Admins;

use App\Core\Traits\Authorization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Repositories\Admins\Contract\AdminRepositoryInterface;

class AdminController extends Controller
{
    use Authorization;

    private $admin;

    public function __construct(AdminRepositoryInterface $admin)
    {
        $this->admin = $admin;
    }

    // Update user
    public function updateProfile(Request $request, $id)
    {
        $admin = $this->admin->find($id);
        $attributes = $request->only('username', 'password');
        if (!empty($attributes)) {
            $guard = $this->guard()->user();
            $guard->update($attributes);
            return redirect()->back()->with('success', 'Thành công');
        }
        return redirect()->back()->with('errors', 'Update không thành công');
    }

    // Update Image
    public function updateImage(ImageRequest $request, $id)
    {
        if ($request->hasFile('image')) {
            $this->admin->updateImage($request->file('image'), $id);
        }
        return redirect()->back();
    }

    // Show user
    public function profile($id)
    {
        $admin = $this->admin->find($id);
        $view = view('backend.admins.profile');
        $view->with('admin', $admin);
        return $view;
    }
}
