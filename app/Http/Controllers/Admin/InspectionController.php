<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Inspection::with(['asset', 'asset.masjidSurau']);
        
        // Admin can see all inspections
        
        $inspections = $query->latest()->paginate(15);
        
        return view('admin.inspections.index', compact('inspections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::with('masjidSurau')->get();
        
        return view('admin.inspections.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'tarikh_pemeriksaan' => 'required|date',
            'kondisi_aset' => 'required|string',
            'nama_pemeriksa' => 'required|string',
            'catatan_pemeriksaan' => 'nullable|string',
            'tindakan_diperlukan' => 'nullable|string',
            'tarikh_pemeriksaan_akan_datang' => 'nullable|date|after:tarikh_pemeriksaan',
            'gambar_pemeriksaan' => 'nullable|array',
            'gambar_pemeriksaan.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_pemeriksaan')) {
            $images = [];
            foreach ($request->file('gambar_pemeriksaan') as $image) {
                $path = $image->store('inspections', 'public');
                $images[] = $path;
            }
            $validated['gambar_pemeriksaan'] = $images;
        }

        $inspection = Inspection::create($validated);

        return redirect()->route('admin.inspections.show', $inspection)
                        ->with('success', 'Pemeriksaan berjaya direkodkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inspection $inspection)
    {
        $inspection->load(['asset', 'asset.masjidSurau']);
        
        // Get related inspections for the same asset
        $relatedInspections = Inspection::where('asset_id', $inspection->asset_id)
                                       ->where('id', '!=', $inspection->id)
                                       ->latest()
                                       ->limit(5)
                                       ->get();
        
        return view('admin.inspections.show', compact('inspection', 'relatedInspections'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspection $inspection)
    {
        $assets = Asset::with('masjidSurau')->get();
        
        return view('admin.inspections.edit', compact('inspection', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspection $inspection)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'tarikh_pemeriksaan' => 'required|date',
            'kondisi_aset' => 'required|string',
            'nama_pemeriksa' => 'required|string',
            'catatan_pemeriksaan' => 'nullable|string',
            'tindakan_diperlukan' => 'nullable|string',
            'tarikh_pemeriksaan_akan_datang' => 'nullable|date|after:tarikh_pemeriksaan',
            'gambar_pemeriksaan' => 'nullable|array',
            'gambar_pemeriksaan.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_pemeriksaan')) {
            $images = $inspection->gambar_pemeriksaan ?? [];
            foreach ($request->file('gambar_pemeriksaan') as $image) {
                $path = $image->store('inspections', 'public');
                $images[] = $path;
            }
            $validated['gambar_pemeriksaan'] = $images;
        }

        $inspection->update($validated);

        return redirect()->route('admin.inspections.show', $inspection)
                        ->with('success', 'Rekod pemeriksaan berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection)
    {
        $inspection->delete();

        return redirect()->route('admin.inspections.index')
                        ->with('success', 'Rekod pemeriksaan berjaya dipadamkan.');
    }
}
