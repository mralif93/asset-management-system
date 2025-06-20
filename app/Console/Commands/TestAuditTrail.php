<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Models\AuditTrail;
use App\Services\AuditTrailService;

class TestAuditTrail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test audit trail functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Audit Trail System...');
        
        // Get count before test
        $beforeCount = AuditTrail::count();
        $this->info("Current audit trail records: {$beforeCount}");
        
        // Test 1: Manual logging
        $this->info("\n1. Testing manual audit logging...");
        $trail = AuditTrailService::logCustom(
            'TEST', 
            'Testing audit trail system from console',
            null,
            ['test_data' => 'sample'],
            'success'
        );
        
        if ($trail) {
            $this->info("✓ Manual audit log created with ID: {$trail->id}");
        } else {
            $this->error("✗ Failed to create manual audit log");
        }
        
        // Test 2: Model event logging (if we have data)
        $masjidSurau = MasjidSurau::first();
        if ($masjidSurau) {
            $this->info("\n2. Testing automatic model audit logging...");
            
            // Create a test asset which should trigger audit logging
            $asset = Asset::create([
                'masjid_surau_id' => $masjidSurau->id,
                'no_siri_pendaftaran' => 'TEST-' . now()->format('YmdHis'),
                'nama_aset' => 'Test Asset for Audit',
                'jenis_aset' => 'Testing Equipment',
                'tarikh_perolehan' => now()->toDateString(),
                'kaedah_perolehan' => 'Testing',
                'nilai_perolehan' => 100.00,
                'umur_faedah_tahunan' => 5,
                'susut_nilai_tahunan' => 20.00,
                'lokasi_penempatan' => 'Test Location',
                'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
                'status_aset' => 'Aktif',
                'catatan' => 'Test asset created by audit trail test',
            ]);
            
            $this->info("✓ Test asset created with ID: {$asset->id}");
            
            // Check if audit log was created
            $assetAuditLog = AuditTrail::where('model_type', Asset::class)
                ->where('model_id', $asset->id)
                ->where('action', 'CREATE')
                ->first();
                
            if ($assetAuditLog) {
                $this->info("✓ Automatic audit log created for asset creation with ID: {$assetAuditLog->id}");
            } else {
                $this->error("✗ No automatic audit log found for asset creation");
            }
            
            // Test update
            $oldName = $asset->nama_aset;
            $asset->update(['nama_aset' => 'Updated Test Asset']);
            
            $assetUpdateLog = AuditTrail::where('model_type', Asset::class)
                ->where('model_id', $asset->id)
                ->where('action', 'UPDATE')
                ->first();
                
            if ($assetUpdateLog) {
                $this->info("✓ Automatic audit log created for asset update with ID: {$assetUpdateLog->id}");
            } else {
                $this->error("✗ No automatic audit log found for asset update");
            }
            
            // Clean up - delete test asset
            $asset->delete();
            
            $assetDeleteLog = AuditTrail::where('model_type', Asset::class)
                ->where('model_id', $asset->id)
                ->where('action', 'DELETE')
                ->first();
                
            if ($assetDeleteLog) {
                $this->info("✓ Automatic audit log created for asset deletion with ID: {$assetDeleteLog->id}");
            } else {
                $this->error("✗ No automatic audit log found for asset deletion");
            }
            
        } else {
            $this->warn("No Masjid/Surau found, skipping model audit test");
        }
        
        // Test 3: Statistics
        $this->info("\n3. Testing audit trail statistics...");
        $stats = AuditTrailService::getSystemStats();
        $this->info("Total activities: {$stats['total_activities']}");
        $this->info("Today's activities: {$stats['today_activities']}");
        $this->info("Failed activities: {$stats['failed_activities']}");
        $this->info("Unique users: {$stats['unique_users']}");
        
        // Get final count
        $afterCount = AuditTrail::count();
        $this->info("\nFinal audit trail records: {$afterCount}");
        $this->info("New records created during test: " . ($afterCount - $beforeCount));
        
        $this->info("\n✅ Audit Trail Test Completed!");
        
        return 0;
    }
}
