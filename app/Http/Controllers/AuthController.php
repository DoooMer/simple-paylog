<?php

namespace App\Http\Controllers;

use App\services\auth\LoginService;
use Illuminate\Http\Request;

/**
 * Контроллер авторизации.
 */
class AuthController extends Controller
{

    /**
     * Авторизация по логину и паролю.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $loginService = new LoginService($request);

        return response()->json([
            'access_token' => $loginService->login(),
        ]);
    }

    public function logout()
    {
        return 'Log out here';
    }

}