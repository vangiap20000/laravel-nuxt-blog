<?php 

namespace App\Services\Auth;

use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Services\AbstractBaseService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthService extends AbstractBaseService implements AuthServiceInterface {

    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }

    /**
     * The function handel login.
     *
     * @param array $attributes The attribute.
     *
     * @return mixed
     */
    public function login($attributes)
    {
        return Auth::attempt(['email' => $attributes['email'], 'password' => $attributes['password']]);
    }

    /**
     * The function handel register user.
     *
     * @param array $attributes The attribute.
     *
     * @return mixed
     */
    public function register($attributes)
    {
        try {
            DB::beginTransaction();
            $this->create([
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => $attributes['password'],
            ]);
            DB::commit();

            $user = $this->findBy('email', $attributes['email']);
            Auth::login($user);
            
            return $user;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * The function handel reset password.
     *
     * @param array $email The email user.
     *
     * @return bool
     */
    public function resetPassword($email)
    {
        try {
            DB::beginTransaction();
            $password = Str::random(8);

            Mail::to($email)->send(new ResetPassword(
                ['password' => $password]
            ));
            $user = $this->findBy('email', $email);
            $user->update(['password' => $password]);
            DB::commit();
            
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = $exception->getMessage();
            logger($message);
            return false;
        }
    }
}