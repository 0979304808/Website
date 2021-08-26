<?php

namespace App\Http\Controllers\BackEnd;

use App\Core\Traits\Authorization;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    use Authorization;

    public function index()
    {
        return view('backend.dashboard.index');
    }

    public function logout()
    {
        $this->guard()->logout();
        return redirect()->route('backend.index');
    }
}
