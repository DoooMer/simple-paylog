<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Определяет методы проверки доступа.
 */
trait CheckAccess
{
    /**
     * @var User|Authenticatable|null
     */
    private $user;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
    }

    /**
     * Проверка роли пользователя.
     *
     * @param string $roleName
     * @return bool
     */
    public function can(string $roleName): bool
    {
        return $this->user->role === $roleName;
    }

    /**
     * Проверяет роль пользователя и выбрасывает исключение.
     *
     * @param string $roleName
     */
    public function check(string $roleName): void
    {
        if (!$this->can($roleName)) {
            throw new AccessDeniedHttpException('Access denied');
        }
    }
}