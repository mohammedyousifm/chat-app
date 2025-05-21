<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        $userID = auth::id();
        $user = User::findOrFail($userID);
        return view('profile', [
            'user' => $user
        ]);
    }
    /**
     * Save the profile Picture in  User Model
     * imagePathuse form name="profile"
     */
    public function profilePicture(Request $request)
    {
        // Validate the incoming image
        $request->validate([
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user(); // or User::find($id);

        // Store the image
        if ($request->hasFile('profile')) {
            // Delete old image if exists
            if ($user->imagePath && Storage::disk('public')->exists($user->imagePath)) {
                Storage::disk('public')->delete($user->imagePath);
            }
            // Store new image and get the path
            $path = $request->file('profile')->store('profile_images', 'public');

            // Save the path in DB
            $user->imagePath = $path;
            $user->save();
        }


        return back()->with('success', 'Profile picture updated!');
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
