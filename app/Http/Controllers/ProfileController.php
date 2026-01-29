<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'staff' => $request->user()->staff,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle profile picture
        if ($request->hasFile('profile_pic')) {
            // Delete old picture if exists
            if ($user->profile_pic) {
                $this->imageService->delete($user->profile_pic);
            }

            $path = $this->imageService->process($request->file('profile_pic'), 'profiles', [
                'width' => 300,
                'height' => 300,
                'format' => 'webp'
            ]);

            $user->profile_pic = $path;
        }

        $user->save();

        // Update Staff profile if user is staff
        if ($user->role === 'staff' && $user->staff) {
            $staffData = $validated;

            // Sync user changes to staff record
            $staffData['name'] = $user->name;
            $staffData['email'] = $user->email;
            $staffData['profile_pic'] = $user->profile_pic;

            $user->staff->update($staffData);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $user = $request->user();

        // Mark for deletion instead of immediate delete
        $user->update([
            'deletion_requested_at' => now(),
            'deletion_reason' => $request->reason,
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'account-deletion-requested');
    }
}
