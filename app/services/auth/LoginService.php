<?php

namespace App\services\auth;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Сервис авторизации.
 */
class LoginService
{
    /**
     * @var string
     */
    private $login;
    /**
     * @var string
     */
    private $password;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->parseLoginAndPassword($request);
    }

    /**
     * Выполнение авторизации. Возвращает токен в случае успеха.
     *
     * @return null|string
     */
    public function login(): ?string
    {
        $user = $this->findUser();

        if (!$user) {
            return null;
        }

        if (!$this->validatePassword($user)) {
            return null;
        }

        return $this->createToken($user);
    }

    /**
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private function findUser()
    {
        return User::query()->where(['name' => $this->login])->firstOrFail();
    }

    /**
     * Проверка полученного пароля.
     *
     * @param User $user
     * @return bool
     */
    private function validatePassword(User $user): bool
    {
        return Hash::check($this->password, $user->password_hash);
    }

    /**
     * Создание или получение токена.
     *
     * @param User $user
     * @return string
     */
    private function createToken(User $user): string
    {
        $secret = env('JWT_SECRET');
        $data = [
            'iat' => time(),
            'jti' => base64_encode(uniqid()),
            'iss' => url('/', [], false),
            'nbf' => time(),
            'exp' => time() + 3600,
            'data' => [
                'userId' => $user->id,
            ],
        ];

        return JWT::encode($data, $secret, 'HS512');
    }

    /**
     * Получение логина и пароля из запроса.
     *
     * @param Request $request
     */
    private function parseLoginAndPassword(Request $request)
    {
        $credentials = $request->all(['name', 'password']);
        $this->login = $credentials['name'];
        $this->password = $credentials['password'];
    }
}