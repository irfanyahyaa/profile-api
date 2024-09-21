<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends BaseController
{
    public function __invoke(Request $request)
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if ($removeToken) {
            return $this->sendResponse([], 'User logged out successfully');
        }
    }
}
