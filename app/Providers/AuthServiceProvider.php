<?php

namespace App\Providers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            /** @var $request Request */
            // получение заголовка авторизации
            $bearer = $request->header('Authorization');
            $token = null;

            if ($bearer) {
                // поиск токена
                if (preg_match('/Bearer\s(\S+)/', $bearer, $matches)) {
                    $token = $matches[1];
                }
            }

            if ($token !== null) {
                // расшифровка токена
                $payload = JWT::decode($token, env('JWT_SECRET'), ['HS512']);
                $userId = null;

                // получение ID пользователя из токена
                if (property_exists($payload, 'data') && $payload->data instanceof \stdClass) {
                    if (property_exists($payload->data, 'userId')) {
                        $userId = $payload->data->userId;
                    }
                }

                // поиск пользователя по ID
                return User::query()->where(['id' => $userId])->firstOrFail();
            }

        });
    }
}
