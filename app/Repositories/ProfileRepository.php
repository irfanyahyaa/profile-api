<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository
{
    public function all()
    {
        return Profile::whereNull('deleted_at')->get();
    }

    public function find($id)
    {
        return Profile::find($id);
    }

    public function update($profile, $data)
    {
        return $profile->update($data);
    }

    public function delete($profile)
    {
        return $profile->delete();
    }
}
