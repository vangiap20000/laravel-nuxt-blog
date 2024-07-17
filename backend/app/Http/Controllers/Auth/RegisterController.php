<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\AuthServiceInterface;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService; 
    }
    

    public function handleRegister(RegisterRequest $request)
    {
        return $this->authService->register($request->except('_token'))
            ? $this->resultRest()
            : $this->resultRest(500, 'Fail');
    }
}
