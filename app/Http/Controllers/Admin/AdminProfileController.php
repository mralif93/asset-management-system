<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\MasjidSurau;
use App\Services\AuditTrailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    /**
     * Display the admin's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        
        // Log profile view
        AuditTrailService::logView($user, 'Admin Profile', 'admin-profile');
        
        return view('admin.profile.edit', [
            'user' => $user,
            'masjidSuraus' => $masjidSuraus,
        ]);
    }

    /**
     * Update the admin's profile information.
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
            'masjid_surau_id' => ['nullable', 'exists:masjid_surau,id'],
        ]);
        
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        
        // Log profile update
        AuditTrailService::logUpdate($user, $oldData, $user->toArray());

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the admin's password.
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
            'Admin password updated',
            ['action' => 'Password changed by admin']
        );

        return back()->with('status', 'password-updated');
    }

    /**
     * Show admin profile settings.
     */
    public function settings(Request $request): View
    {
        $user = $request->user();
        
        return view('admin.profile.settings', [
            'user' => $user,
        ]);
    }

    /**
     * Update admin settings.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'notifications_enabled' => ['boolean'],
            'email_notifications' => ['boolean'],
            'theme_preference' => ['string', 'in:light,dark,auto'],
            'language' => ['string', 'in:en,ms'],
        ]);

        // Store settings in user's meta or create a settings table
        // For now, we'll just log the settings change
        AuditTrailService::logCustom(
            $user,
            'settings_update',
            'User',
            $user->id,
            'Admin settings updated',
            $validated
        );

        return back()->with('status', 'settings-updated');
    }

    /**
     * Show admin activity log.
     */
    public function activity(Request $request): View
    {
        $user = $request->user();
        
        // Get user's recent activities
        $activities = \App\Models\AuditTrail::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.profile.activity', [
            'user' => $user,
            'activities' => $activities,
        ]);
    }

    /**
     * Delete the admin's account (restricted).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        
        // Prevent deletion if this is the only admin
        $adminCount = \App\Models\User::where('role', 'admin')->count();
        if ($adminCount <= 1) {
            return back()->withErrors([
                'password' => 'Tidak boleh memadamkan akaun admin terakhir dalam sistem.'
            ]);
        }

        // Log account deletion
        AuditTrailService::logCustom(
            $user,
            'account_deletion',
            'User',
            $user->id,
            'Admin account deleted',
            ['deleted_by' => $user->id]
        );

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Akaun admin telah berjaya dipadamkan.');
    }
} 