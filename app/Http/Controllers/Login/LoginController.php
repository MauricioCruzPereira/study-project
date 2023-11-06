<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Services\Login\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends BaseController
{

    public function __construct($service = null) {
        $this->service = (new LoginService())
        ->setModel(User::class);
      }

    /**
     * Login user
     *
     * @return JsonResponse
     */
    public function login() : JsonResponse{
        return response()->json($this->service->login());
    }

    /**
     * Logout user
     *
     * @return JsonResponse
     */
    public function logout() : JsonResponse{
        return response()->json($this->service->logout());
    }

    /**
     * Logout me
     *
     * @return JsonResponse
     */
    public function me() : JsonResponse{
        return response()->json($this->service->me());
    }
}
