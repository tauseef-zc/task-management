<?php

namespace App\Services\V1\Auth;

use App\Jobs\V1\Auth\VerifyUserEmail;
use App\Models\User;
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
}
