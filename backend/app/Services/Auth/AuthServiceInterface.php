<?php

namespace App\Services\Auth;

use App\Services\AbstractServiceInterface;

interface AuthServiceInterface extends AbstractServiceInterface
{
    /**
     * The function handel login.
     *
     * @param array $attributes The attribute.
     *
     * @return mixed
     */
    public function login($attributes);

    /**
     * The function handel register user.
     *
     * @param array $attributes The attribute.
     *
     * @return mixed
     */
    public function register($attributes);

    /**
     * The function handel reset password.
     *
     * @param array $email The email user.
     *
     * @return bool
     */
    public function resetPassword($email);
}
