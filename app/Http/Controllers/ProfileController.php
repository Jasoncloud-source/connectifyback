<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'interest' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();
        
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $profileData = [
            'name' => $validated['name'],
            'interest' => $validated['interest'],
            'avatar_path' => $avatarPath
        ];

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return response()->json($user->load('profile'));
    }

    public function completeOnboarding()
    {
        $user = Auth::user();
        
        if ($user->profile) {
            $user->profile->update(['onboarding_complete' => true]);
        } else {
            $user->profile()->create(['onboarding_complete' => true]);
        }

        return response()->json(['message' => 'Onboarding completed']);
    }
}