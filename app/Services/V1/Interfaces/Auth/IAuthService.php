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
}