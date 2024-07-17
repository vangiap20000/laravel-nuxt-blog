<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService; 
    }
    
    public function handleLogin(LoginRequest $request)
    {   
        return $this->authService->login($request->except('_token'))
            ? $this->resultRest()
            : $this->resultRest(500, 'Unauthorized');
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return $this->resultRest();
    }
}
