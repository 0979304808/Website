<?php

namespace App\Http\Controllers\BackEnd\Auth;

use App\Core\JsonResponse;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Admins\Contract\AdminRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    private $model;

    public function __construct(AdminRepositoryInterface $admin)
    {
        $this->model = $admin;
    }

    // View Register
    public function index()
    {
        return view('backend.auth.register');
    }


    // Register 
    public function register(RegisterRequest $request)
    {
        $params = $request->only('username', 'email', 'password');
        try{
            if ($params['password'] === $request->get('password_confirmation') ) {
                $this->model->create($params);
            };
            return redirect()->back()->with('msg','dang ky thanh cong');
        }catch(\Exception $e){
            return response(new JsonResponse([], $e->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
