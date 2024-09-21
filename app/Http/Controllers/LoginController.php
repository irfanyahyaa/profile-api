<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', 422);
        }

        $credentials = $request->only('email', 'password');
        $token = auth()->guard('api')->attempt($credentials);

        if (!$token) {
            return $this->sendError('Unauthorized', 401);
        }

        return $this->sendResponse(
            new LoginResource(auth()->guard('api')->user(), $token),
            'User logged in successfully'
        );
    }
}
