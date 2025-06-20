<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRecord;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MaintenanceRecord::with(['asset', 'asset.masjidSurau']);
        
        // Admin can see all maintenance records
        
        $maintenanceRecords = $query->latest()->paginate(15);
        
        return view('admin.maintenance-records.index', compact('maintenanceRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::with('masjidSurau')->get();
        
        return view('admin.maintenance-records.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_penyelenggaraan' => 'required|string',
            'tarikh_penyelenggaraan' => 'required|date',
            'kos_penyelenggaraan' => 'required|numeric|min:0',
            'penyedia_perkhidmatan' => 'required|string|max:255',
            'catatan_penyelenggaraan' => 'nullable|string',
            'tarikh_penyelenggaraan_akan_datang' => 'nullable|date|after:tarikh_penyelenggaraan',
            'gambar_penyelenggaraan' => 'nullable|array',
            'gambar_penyelenggaraan.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_penyelenggaraan')) {
            $images = [];
            foreach ($request->file('gambar_penyelenggaraan') as $image) {
                $path = $image->store('maintenance', 'public');
                $images[] = $path;
            }
            $validated['gambar_penyelenggaraan'] = $images;
        }

        $validated['user_id'] = Auth::id();

        $maintenanceRecord = MaintenanceRecord::create($validated);

        return redirect()->route('admin.maintenance-records.show', $maintenanceRecord)
                        ->with('success', 'Rekod penyelenggaraan berjaya disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceRecord $maintenanceRecord)
    {
        $maintenanceRecord->load(['asset', 'asset.masjidSurau', 'user']);
        
        return view('admin.maintenance-records.show', compact('maintenanceRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceRecord $maintenanceRecord)
    {
        $assets = Asset::with('masjidSurau')->get();
        
        return view('admin.maintenance-records.edit', compact('maintenanceRecord', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenanceRecord $maintenanceRecord)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_penyelenggaraan' => 'required|string',
            'tarikh_penyelenggaraan' => 'required|date',
            'kos_penyelenggaraan' => 'required|numeric|min:0',
            'penyedia_perkhidmatan' => 'required|string|max:255',
            'catatan_penyelenggaraan' => 'nullable|string',
            'tarikh_penyelenggaraan_akan_datang' => 'nullable|date|after:tarikh_penyelenggaraan',
            'gambar_penyelenggaraan' => 'nullable|array',
            'gambar_penyelenggaraan.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_penyelenggaraan')) {
            $images = $maintenanceRecord->gambar_penyelenggaraan ?? [];
            foreach ($request->file('gambar_penyelenggaraan') as $image) {
                $path = $image->store('maintenance', 'public');
                $images[] = $path;
            }
            $validated['gambar_penyelenggaraan'] = $images;
        }

        $maintenanceRecord->update($validated);

        return redirect()->route('admin.maintenance-records.show', $maintenanceRecord)
                        ->with('success', 'Rekod penyelenggaraan berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceRecord $maintenanceRecord)
    {
        $maintenanceRecord->delete();

        return redirect()->route('admin.maintenance-records.index')
                        ->with('success', 'Rekod penyelenggaraan berjaya dipadamkan.');
    }
}
