<?php

namespace App\Services\V1\Interfaces\Auth;

use App\Models\User;
use App\Services\V1\Interfaces\ServiceInterface;


interface IAuthService extends ServiceInterface
{
    /**
     * @param User $user
     */
    public function __construct(User $user);

    /**
     * login
     *
     * @param  array $credentials
     * @return array
     */
    public function login(array $credentials): array;

    /**
     * register
     *
     * @param  array $data
     * @return array
     */
    public function register(array $data): array;

    /**
     * forgotPassword
     * 
     * @param string $email
     * @return array
     */
    public function forgotPassword(string $email): array;

    /**
     * verifyOtp
     * 
     * @param array $payload
     * @return array
     */
    public function verifyOtp(array $payload): array;

    /**
     * verifyUserEmail
     * 
     * @param array $payload
     * @return array
     */
    public function verifyUserEmail(array $payload): array;

}