<?php

namespace App\Http\Controllers\BackEnd\Auth;

use App\Core\Traits\Authorization;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use Authorization;

    // View Login
    public function index()
    {
        return view('backend.auth.login');
    }

    // Login
    public function login(LoginRequest $request)
    {
        $params = $request->only('email', 'password', 'active');
        if ($this->guard()->attempt($params, true)) {
            return redirect()->route('backend.dashboard');
        }
        return redirect()->back()->withErrors(['msg' => 'Account does not have access!']);
    }
}
