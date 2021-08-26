<?php

namespace App\Http\Controllers\Backend\Admins;

use App\Admin;
use App\Core\Traits\Authorization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Repositories\Admins\AdminRepository;
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
    public function updateProfile(Request $request,Admin $admin){
        $attributes = $request->only('username', 'password');
        if(!empty($attributes)){
            $guard = $this->guard()->user();
            $guard->update($attributes);
            return redirect()->back()->with('success','Thành công');
        }
        return redirect()->back()->with('errors','Update không thành công');
    }

    // Update Image
    public function updateImage(ImageRequest $request, Admin $admin){
        if($request->hasFile('image')){
            $repo = new AdminRepository($admin);
            $repo->updateImage($request->file('image'));
        }
        return redirect()->back();
    }

    // Show user
    public function profile(Admin $admin){
        $view = view('backend.admins.profile');
        $view->with('admin', $admin);
        return $view;
    }
}
