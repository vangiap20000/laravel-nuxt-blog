<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\Auth\AuthServiceInterface;

class ResetPasswordController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService; 
    }
    

    public function handelReset(ResetPasswordRequest $request)
    {
        return $this->authService->resetPassword($request->email)
            ? $this->resultRest()
            : $this->resultRest(500, 'fail');
    }
}
