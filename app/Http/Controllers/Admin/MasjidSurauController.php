<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasjidSurauController extends Controller
{
    /**
     * Display a listing of the masjid/surau.
     */
    public function index(Request $request)
    {
        $query = MasjidSurau::withCount(['assets', 'users']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('singkatan_nama', 'like', "%{$search}%")
                  ->orWhere('imam_ketua', 'like', "%{$search}%")
                  ->orWhere('bandar', 'like', "%{$search}%")
                  ->orWhere('daerah', 'like', "%{$search}%")
                  ->orWhere('negeri', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->get('jenis'));
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->get('kategori'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $masjidSuraus = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistics for the index page
        $statistics = [
            'total_masjid_surau' => MasjidSurau::count(),
            'total_masjid' => MasjidSurau::where('jenis', 'Masjid')->count(),
            'total_surau' => MasjidSurau::where('jenis', 'Surau')->count(),
            'total_assets' => DB::table('assets')->count(),
        ];

        return view('admin.masjid-surau.index', compact('masjidSuraus', 'statistics'));
    }

    /**
     * Show the form for creating a new masjid/surau.
     */
    public function create()
    {
        return view('admin.masjid-surau.create');
    }

    /**
     * Store a newly created masjid/surau in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan_nama' => 'nullable|string|max:20',
            'jenis' => 'required|in:Masjid,Surau',
            'kategori' => 'nullable|in:Kariah,Persekutuan,Negeri,Swasta,Wakaf',
            'alamat_baris_1' => 'nullable|string|max:255',
            'alamat_baris_2' => 'nullable|string|max:255',
            'alamat_baris_3' => 'nullable|string|max:255',
            'poskod' => 'nullable|string|max:10',
            'bandar' => 'nullable|string|max:100',
            'negeri' => 'nullable|string|max:100',
            'negara' => 'nullable|string|max:100',
            'daerah' => 'required|string|max:100',
            'no_telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'imam_ketua' => 'nullable|string|max:255',
            'bilangan_jemaah' => 'nullable|integer|min:0',
            'tahun_dibina' => 'nullable|integer|min:1800|max:' . date('Y'),
            'status' => 'required|in:Aktif,Tidak Aktif',
            'catatan' => 'nullable|string|max:1000',
        ]);

        MasjidSurau::create($validated);

        return redirect()->route('admin.masjid-surau.index')
                        ->with('success', 'Masjid/Surau berjaya ditambah.');
    }

    /**
     * Display the specified masjid/surau.
     */
    public function show(MasjidSurau $masjidSurau)
    {
        $masjidSurau->load(['assets', 'users']);
        
        // Get asset statistics for this masjid/surau
        $assetStats = [
            'total_assets' => $masjidSurau->assets->count(),
            'total_value' => $masjidSurau->assets->sum('nilai_perolehan'),
            'active_assets' => $masjidSurau->assets->where('status_aset', 'aktif')->count(),
            'maintenance_assets' => $masjidSurau->assets->where('status_aset', 'dalam_penyelenggaraan')->count(),
            'damaged_assets' => $masjidSurau->assets->where('status_aset', 'rosak')->count(),
        ];

        // Get recent activities
        $recentAssets = $masjidSurau->assets()->latest()->limit(5)->get();
        $activeUsers = $masjidSurau->users()->where('email_verified_at', '!=', null)->count();

        return view('admin.masjid-surau.show', compact('masjidSurau', 'assetStats', 'recentAssets', 'activeUsers'));
    }

    /**
     * Show the form for editing the specified masjid/surau.
     */
    public function edit(MasjidSurau $masjidSurau)
    {
        return view('admin.masjid-surau.edit', compact('masjidSurau'));
    }

    /**
     * Update the specified masjid/surau in storage.
     */
    public function update(Request $request, MasjidSurau $masjidSurau)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan_nama' => 'nullable|string|max:20',
            'jenis' => 'required|in:Masjid,Surau',
            'kategori' => 'nullable|in:Kariah,Persekutuan,Negeri,Swasta,Wakaf',
            'alamat_baris_1' => 'nullable|string|max:255',
            'alamat_baris_2' => 'nullable|string|max:255',
            'alamat_baris_3' => 'nullable|string|max:255',
            'poskod' => 'nullable|string|max:10',
            'bandar' => 'nullable|string|max:100',
            'negeri' => 'nullable|string|max:100',
            'negara' => 'nullable|string|max:100',
            'daerah' => 'required|string|max:100',
            'no_telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'imam_ketua' => 'nullable|string|max:255',
            'bilangan_jemaah' => 'nullable|integer|min:0',
            'tahun_dibina' => 'nullable|integer|min:1800|max:' . date('Y'),
            'status' => 'required|in:Aktif,Tidak Aktif',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $masjidSurau->update($validated);

        return redirect()->route('admin.masjid-surau.index')
                        ->with('success', 'Masjid/Surau berjaya dikemas kini.');
    }

    /**
     * Remove the specified masjid/surau from storage.
     */
    public function destroy(MasjidSurau $masjidSurau)
    {
        // Check if masjid/surau has assets
        if ($masjidSurau->assets()->count() > 0) {
            return redirect()->route('admin.masjid-surau.index')
                            ->with('error', 'Tidak dapat memadamkan. Masjid/Surau ini mempunyai aset yang berkaitan.');
        }

        // Check if masjid/surau has users
        if ($masjidSurau->users()->count() > 0) {
            return redirect()->route('admin.masjid-surau.index')
                            ->with('error', 'Tidak dapat memadamkan. Masjid/Surau ini mempunyai pengguna yang berkaitan.');
        }

        $masjidSurau->delete();

        return redirect()->route('admin.masjid-surau.index')
                        ->with('success', 'Masjid/Surau berjaya dipadamkan.');
    }

    /**
     * Toggle the status of the specified masjid/surau.
     */
    public function toggleStatus(MasjidSurau $masjidSurau)
    {
        $newStatus = $masjidSurau->status === 'Aktif' ? 'Tidak Aktif' : 'Aktif';
        $masjidSurau->update(['status' => $newStatus]);

        return redirect()->route('admin.masjid-surau.index')
                        ->with('success', 'Status Masjid/Surau berjaya dikemas kini.');
    }

    /**
     * Bulk delete selected masjid/surau.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return redirect()->route('admin.masjid-surau.index')
                            ->with('error', 'Tiada Masjid/Surau dipilih.');
        }

        // Check if any selected masjid/surau has assets or users
        $hasRelatedData = MasjidSurau::whereIn('id', $ids)
                                   ->where(function($query) {
                                       $query->has('assets')->orHas('users');
                                   })->exists();

        if ($hasRelatedData) {
            return redirect()->route('admin.masjid-surau.index')
                            ->with('error', 'Tidak dapat memadamkan. Sebahagian Masjid/Surau mempunyai data berkaitan.');
        }

        MasjidSurau::whereIn('id', $ids)->delete();

        return redirect()->route('admin.masjid-surau.index')
                        ->with('success', count($ids) . ' Masjid/Surau berjaya dipadamkan.');
    }
} 