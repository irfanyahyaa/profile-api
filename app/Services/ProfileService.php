<?php

namespace App\Services;

use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ProfileService
{
    protected $profileRepo;

    public function __construct(ProfileRepository $profileRepo)
    {
        $this->profileRepo = $profileRepo;
    }

    public function getAllProfiles()
    {
        return $this->profileRepo->all();
    }

    public function getProfile($id)
    {
        return Cache::remember('profile_'.$id, 10, function () use ($id) {
            return $this->profileRepo->find($id);
        });
    }

    public function updateProfile($request, $profile)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation Error.', 422);
        }

        return $this->profileRepo->update($profile, $request->only(['full_name', 'address', 'gender', 'marital_status']));
    }

    public function deleteProfile($profile)
    {
        return $this->profileRepo->delete($profile);
    }
}
