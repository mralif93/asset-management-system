<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('masjidSurau');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Filter by masjid/surau
        if ($request->has('masjid_surau') && $request->masjid_surau) {
            $query->where('masjid_surau_id', $request->masjid_surau);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } else {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();

        return view('admin.users.index', compact('users', 'masjidSuraus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        return view('admin.users.create', compact('masjidSuraus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'masjid_surau_id' => 'required|exists:masjids_suraus,id',
            'email_verified_at' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        if (isset($validated['email_verified_at']) && $validated['email_verified_at']) {
            $validated['email_verified_at'] = now();
        } else {
            unset($validated['email_verified_at']);
        }

        $user = User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Pengguna berjaya dicipta.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('masjidSurau');
        
        // Get user statistics based on actual database structure
        $stats = [
            // Count assets from user's masjid/surau
            'total_assets' => $user->masjidSurau ? $user->masjidSurau->assets()->count() : 0,
            
            // Since asset_movements, inspections etc don't have user_id in the original structure,
            // we'll calculate based on the user's masjid/surau assets
            'pending_movements' => $user->masjidSurau ? 
                \App\Models\AssetMovement::whereIn('asset_id', $user->masjidSurau->assets()->pluck('id'))
                    ->where('status_pergerakan', 'Dimohon')
                    ->count() : 0,
                    
            'completed_inspections' => $user->masjidSurau ?
                \App\Models\Inspection::whereIn('asset_id', $user->masjidSurau->assets()->pluck('id'))
                    ->count() : 0,
                    
            'recent_activities' => $user->masjidSurau ?
                \App\Models\AssetMovement::whereIn('asset_id', $user->masjidSurau->assets()->pluck('id'))
                    ->latest()
                    ->take(5)
                    ->get() : collect(),
        ];
        
        return view('admin.users.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        return view('admin.users.edit', compact('user', 'masjidSuraus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'masjid_surau_id' => 'required|exists:masjids_suraus,id',
            'email_verified_at' => 'nullable|boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        if (isset($validated['email_verified_at']) && $validated['email_verified_at']) {
            $validated['email_verified_at'] = now();
        } elseif (isset($validated['email_verified_at']) && !$validated['email_verified_at']) {
            $validated['email_verified_at'] = null;
        } else {
            unset($validated['email_verified_at']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Pengguna berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deletion of current user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Anda tidak boleh memadam akaun anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'Pengguna berjaya dipadamkan.');
    }

    /**
     * Toggle user status (active/inactive)
     */
    public function toggleStatus(User $user)
    {
        // Prevent deactivating current user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Anda tidak boleh menyahaktifkan akaun anda sendiri.');
        }

        $user->email_verified_at = $user->email_verified_at ? null : now();
        $user->save();

        $status = $user->email_verified_at ? 'aktif' : 'tidak aktif';
        
        return redirect()->back()
                        ->with('success', "Status pengguna berjaya ditukar kepada {$status}.");
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user)
    {
        // Prevent resetting current user's password
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Anda tidak boleh mereset kata laluan anda sendiri.');
        }

        $user->password = Hash::make('password123');
        $user->save();

        return redirect()->back()
                        ->with('success', 'Kata laluan pengguna berjaya direset kepada "password123".');
    }

    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $userIds = $request->input('user_ids', []);
        
        // Prevent deletion of current user
        $userIds = array_filter($userIds, function($id) {
            return $id != auth()->id();
        });

        if (empty($userIds)) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Tiada pengguna dipilih untuk dipadamkan.');
        }

        $deletedCount = User::whereIn('id', $userIds)->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', "Berjaya memadam {$deletedCount} pengguna.");
    }
} 