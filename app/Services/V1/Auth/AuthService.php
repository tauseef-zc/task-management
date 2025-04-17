<?php

namespace App\Services\V1\Auth;

use App\Jobs\V1\Auth\VerifyUserEmail;
use App\Models\User;
use App\Notifications\V1\Auth\ForgotPasswordNotification;
use App\Services\V1\BaseService;
use App\Services\V1\Interfaces\Auth\IAuthService;
use Illuminate\Http\Response;

class AuthService extends BaseService implements IAuthService
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * login
     *
     * @param  array $credentials
     * @return array
     */
    public function login(array $credentials): array
    {
        try {

            if (!auth()->attempt($credentials)) {
                return $this->error('The provided credentials are incorrect.', Response::HTTP_FORBIDDEN);
            }

            $this->user = auth()->user();

            if (!$this->user->hasVerifiedEmail()) {
                VerifyUserEmail::dispatch($this->user->email);
            }

            return $this->payload([
                'accessToken' => $this->user->createToken($this->user->email)->plainTextToken
            ]);

        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @param array $payload
     * @return array
     */
    public function register(array $payload): array
    {
        try {

            $user = $this->user->create($payload);
            VerifyUserEmail::dispatch($user->email);

            return $this->payload([
                'message' => 'User created successfully',
            ], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), Response::HTTP_BAD_REQUEST );
        }
    }

    /**
     * forgotPassword
     *
     * @param string $email
     * @return array
     */
    public function forgotPassword(string $email): array
    {
        $user = $this->user->where('email', $email)->first();

        $otp = $user->createOtp();
        $user->notify(new ForgotPasswordNotification($otp->otp));

        return $this->payload(['message'  => 'Reset password otp sent to your email address']);
    }

     /**
     * @param array $payload
     * @param bool $verifyEmail
     * @return array
     */
    public function verifyOtp(array $payload): array
    {
        $user = $this->user->where(['email' => $payload['email']])->first();

        if ($otp = $user->getOtp($payload['otp'])) {

            $user->markOtpAsVerified($otp);

            return $this->payload([
                'message'  => sprintf('The otp for %s has been verified.', $user->email),
                'accessToken' => $user->createToken($user->id, ['reset.password'], now()->addMinutes(30))->plainTextToken
            ]);
        }

        return $this->error('The otp is incorrect.', Response::HTTP_BAD_REQUEST );
    }

    /**
     * @param User $user
     * @return array
     */
    public function verifyUserEmail(array $payload): array
    {
        $user = $this->user->where(['email' => $payload['email']])->first();

        if ($otp = $user->getOtp($payload['otp'])) {
            
            $user->markOtpAsVerified($otp);
            $user->markEmailAsVerified();

            return $this->payload([
                'message'  => sprintf('The email %s has been verified.', $user->email),
            ]);
        }

        return $this->error('The otp is incorrect.', Response::HTTP_BAD_REQUEST );
    }

}
