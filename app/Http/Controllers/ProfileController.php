<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index(): JsonResponse
    {
        $profiles = $this->profileService->getAllProfiles();
        return $this->sendResponse(ProfileResource::collection($profiles), 'Profile retrieved successfully');
    }

    public function show($id): JsonResponse
    {
        $profile = $this->profileService->getProfile($id);

        if (is_null($profile)) {
            return $this->sendError('Profile not found.', 404);
        }

        return $this->sendResponse(new ProfileResource($profile), 'Profile retrieved successfully');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $profile = $this->profileService->getProfile($id);

        if (is_null($profile)) {
            return $this->sendError('Profile not found.', 404);
        }

        if ($profile->user_id !== auth()->id()) {
            return $this->sendError('Unauthorized to update this profile.', 403);
        }

        try {
            $this->profileService->updateProfile($request, $profile);
            return $this->sendResponse(new ProfileResource($profile), 'Profile updated successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function destroy($id): JsonResponse
    {
        $profile = $this->profileService->getProfile($id);

        if (is_null($profile)) {
            return $this->sendError('Profile not found.', 404);
        }

        $this->profileService->deleteProfile($profile);
        return $this->sendResponse(new ProfileResource($profile), 'Profile deleted successfully');
    }

    public function unauthenticated(): JsonResponse
    {
        return $this->sendError('Unauthenticated', 401);
    }
}
