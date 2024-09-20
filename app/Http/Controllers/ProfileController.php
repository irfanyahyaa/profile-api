<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProfileController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->sendResponse(ProfileResource::collection(Profile::all()), 'Profile retrieved successfully');
    }

    public function show($id): JsonResponse
    {
        $profile = Profile::find($id);
        if (is_null($profile)) {
            return $this->sendError('Profile not found.', 404);
        }
        return $this->sendResponse(new ProfileResource($profile), 'Profile retrieved successfully');
    }
}
