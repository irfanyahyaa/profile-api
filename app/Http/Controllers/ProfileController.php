<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->sendResponse(ProfileResource::collection(Profile::all()->whereNull('deleted_at')), 'Profile retrieved successfully');
    }

    public function show($id): JsonResponse
    {
        $profile = Profile::find($id);

        if (is_null($profile)) {
            return $this->sendError('Profile not found.', 404);
        }

        return $this->sendResponse(new ProfileResource($profile), 'Profile retrieved successfully');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', 422);
        }

        $profile = Profile::find($id);

        if (is_null($profile)) {
            return $this->sendError('Profile not found.', 404);
        }

        $profile->update([
            'full_name' => $request->full_name,
            'address' => $request->address,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
        ]);

        return $this->sendResponse(new ProfileResource($profile), 'Profile updated successfully');
    }

    public function destroy($id): JsonResponse
    {
        $profile = Profile::find($id);

        if (is_null($profile)) {
            return $this->sendError('Profile not found.', 404);
        }

        $profile->delete();

        return $this->sendResponse(new ProfileResource($profile), 'Profile deleted successfully');
    }
}
