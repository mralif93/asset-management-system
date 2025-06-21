<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\AuditTrailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Log profile view
        AuditTrailService::logView($user, 'User Profile', 'user-profile');
        
        return view('user.profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $oldData = $user->toArray();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['nullable', 'string', 'max:255'],
        ]);
        
        // Users cannot change their masjid_surau_id - only admins can
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        
        // Log profile update
        AuditTrailService::logUpdate($user, $oldData, $user->toArray());

        return Redirect::route('user.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        // Log password update
        AuditTrailService::logCustom(
            $user,
            'password_update',
            'User',
            $user->id,
            'User password updated',
            ['action' => 'Password changed by user']
        );

        return back()->with('status', 'password-updated');
    }

    /**
     * Show user activity log (limited view).
     */
    public function activity(Request $request): View
    {
        $user = $request->user();
        
        // Get user's recent activities (limited to their own actions)
        $activities = \App\Models\AuditTrail::where('user_id', $user->id)
            ->whereIn('action', ['login', 'logout', 'view', 'profile_update', 'password_update'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('user.profile.activity', [
            'user' => $user,
            'activities' => $activities,
        ]);
    }

    /**
     * Delete the user's account (with restrictions).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
            'confirmation' => ['required', 'in:DELETE'],
        ]);

        $user = $request->user();
        
        // Log account deletion
        AuditTrailService::logCustom(
            $user,
            'account_deletion',
            'User',
            $user->id,
            'User account deleted',
            ['deleted_by' => $user->id, 'role' => 'user']
        );

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Akaun anda telah berjaya dipadamkan.');
    }
} 