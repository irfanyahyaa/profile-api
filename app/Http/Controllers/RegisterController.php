<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Http\Resources\RegisterResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Handle the incoming request.
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if (!$user) {
            return $this->sendError('User could not be created.', 500);
        }

        $profile = Profile::create([
            'user_id' => $user->id,
            'full_name' => $request->name
        ]);


        return $this->sendResponse(
            ['user' => new RegisterResource($user), 'profile' => new ProfileResource($profile)],
            'User created successfully'
        );
    }
}
