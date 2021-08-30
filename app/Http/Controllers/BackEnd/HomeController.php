<?php

namespace App\Http\Controllers\BackEnd;

use App\Core\Traits\Authorization;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    use Authorization;

    // View dashboard
    public function index()
    {
        return view('backend.dashboard.index');
    }

    // Logout
    public function logout()
    {
        $this->guard()->logout();
        return redirect()->route('backend.index');
    }
}
