<?php

namespace Database\Seeders;

use App\Models\Inspection;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InspectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::all();

        // Sample inspection data
        $inspections = [
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(30),
                'kondisi_aset' => 'Baik',
                'tindakan_diperlukan' => 'Tiada tindakan diperlukan',
                'nama_pemeriksa' => 'Ustaz Ahmad bin Ali',
                'catatan_pemeriksaan' => 'Komputer berfungsi dengan baik, perlu kemas kini antivirus',
                'tarikh_pemeriksaan_akan_datang' => Carbon::now()->addDays(90),
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(25),
                'kondisi_aset' => 'Baik',
                'tindakan_diperlukan' => 'Tiada tindakan diperlukan',
                'nama_pemeriksa' => 'Encik Mahmud bin Hassan',
                'catatan_pemeriksaan' => 'Kerusi dalam keadaan baik dan bersih',
                'tarikh_pemeriksaan_akan_datang' => Carbon::now()->addDays(95),
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(20),
                'kondisi_aset' => 'Perlu Penyelenggaraan',
                'tindakan_diperlukan' => 'Servis pembersihan filter',
                'nama_pemeriksa' => 'Ustaz Ahmad bin Ali',
                'catatan_pemeriksaan' => 'Penyaman udara perlu servis filter, bunyi agak bising',
                'tarikh_pemeriksaan_akan_datang' => Carbon::now()->addDays(30),
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(15),
                'kondisi_aset' => 'Baik',
                'tindakan_diperlukan' => 'Tiada tindakan diperlukan',
                'nama_pemeriksa' => 'Haji Ibrahim bin Yusof',
                'catatan_pemeriksaan' => 'Meja dalam keadaan baik, permukaannya licin dan bersih',
                'tarikh_pemeriksaan_akan_datang' => Carbon::now()->addDays(100),
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(10),
                'kondisi_aset' => 'Baik',
                'tindakan_diperlukan' => 'Pembersihan berkala',
                'nama_pemeriksa' => 'Encik Rosli bin Ahmad',
                'catatan_pemeriksaan' => 'Kipas berfungsi dengan baik, perlu dibersihkan',
                'tarikh_pemeriksaan_akan_datang' => Carbon::now()->addDays(90),
            ],
        ];

        // Create inspections for existing assets
        foreach ($inspections as $index => $inspectionData) {
            if ($index < $assets->count()) {
                $asset = $assets[$index];
                
                Inspection::create(array_merge($inspectionData, [
                    'asset_id' => $asset->id,
                ]));
            }
        }

        // Create additional random inspections
        $this->createAdditionalInspections($assets);

        $this->command->info('Inspections seeded successfully!');
    }

    private function createAdditionalInspections($assets)
    {
        $kondisiAset = ['Sangat Baik', 'Baik', 'Sederhana', 'Perlu Penyelenggaraan', 'Rosak'];
        $namaPemeriksa = [
            'Ustaz Ahmad bin Ali',
            'Haji Ibrahim bin Yusof',
            'Encik Mahmud bin Hassan',
            'Encik Rosli bin Ahmad',
            'Ustaz Rahman bin Omar',
            'Haji Abdullah bin Yusof'
        ];

        $tindakanDiperlukan = [
            'Sangat Baik' => [
                'Tiada tindakan diperlukan',
                'Penjagaan rutin sahaja',
                'Teruskan penggunaan normal',
                'Simpan dengan baik'
            ],
            'Baik' => [
                'Tiada tindakan diperlukan',
                'Pembersihan berkala',
                'Penjagaan rutin',
                'Simpan di tempat selamat'
            ],
            'Sederhana' => [
                'Pantau dengan kerap',
                'Pembersihan menyeluruh',
                'Pemeriksaan berkala',
                'Beri perhatian khusus'
            ],
            'Perlu Penyelenggaraan' => [
                'Servis pembersihan',
                'Pemeriksaan lanjut diperlukan',
                'Baik pulih kecil',
                'Ganti bahagian kecil'
            ],
            'Rosak' => [
                'Baik pulih segera',
                'Hantar ke kedai pembaikan',
                'Ganti bahagian utama',
                'Pemeriksaan pakar'
            ]
        ];

        $catatanTemplate = [
            'Sangat Baik' => [
                'Aset dalam keadaan sangat baik dan berfungsi sempurna',
                'Tiada masalah ditemui, prestasi cemerlang',
                'Aset dijaga dengan sangat baik',
                'Kualiti dan prestasi aset sangat memuaskan'
            ],
            'Baik' => [
                'Aset dalam keadaan baik dan berfungsi normal',
                'Tiada masalah ditemui semasa pemeriksaan',
                'Aset well-maintained dan bersih',
                'Prestasi aset memuaskan'
            ],
            'Sederhana' => [
                'Aset masih boleh digunakan tetapi perlu perhatian',
                'Terdapat tanda-tanda penggunaan biasa',
                'Beberapa aspek perlu dipantau',
                'Prestasi masih boleh diterima'
            ],
            'Perlu Penyelenggaraan' => [
                'Terdapat masalah yang perlu diberi perhatian',
                'Aset masih boleh digunakan tetapi perlu servis',
                'Beberapa bahagian menunjukkan tanda-tanda haus',
                'Perlu pemantauan berkala'
            ],
            'Rosak' => [
                'Aset mengalami kerosakan dan tidak boleh digunakan',
                'Memerlukan pembaikan segera sebelum boleh digunakan',
                'Kerosakan menjejaskan fungsi utama aset',
                'Perlu tindakan pembaikan profesional'
            ]
        ];

        // Create multiple inspections for each asset (historical data)
        foreach ($assets as $asset) {
            $numInspections = rand(1, 3); // 1-3 additional inspections per asset
            
            for ($i = 0; $i < $numInspections; $i++) {
                $kondisi = $kondisiAset[array_rand($kondisiAset)];
                $tarikhPemeriksaan = Carbon::now()->subDays(rand(5, 180));
                
                // Calculate next inspection date based on condition
                $nextInspectionDays = match($kondisi) {
                    'Sangat Baik' => rand(120, 180),
                    'Baik' => rand(90, 120),
                    'Sederhana' => rand(60, 90),
                    'Perlu Penyelenggaraan' => rand(30, 60),
                    'Rosak' => rand(7, 30),
                };
                
                Inspection::create([
                    'asset_id' => $asset->id,
                    'tarikh_pemeriksaan' => $tarikhPemeriksaan,
                    'kondisi_aset' => $kondisi,
                    'tindakan_diperlukan' => $tindakanDiperlukan[$kondisi][array_rand($tindakanDiperlukan[$kondisi])],
                    'nama_pemeriksa' => $namaPemeriksa[array_rand($namaPemeriksa)],
                    'catatan_pemeriksaan' => $catatanTemplate[$kondisi][array_rand($catatanTemplate[$kondisi])],
                    'tarikh_pemeriksaan_akan_datang' => $tarikhPemeriksaan->copy()->addDays($nextInspectionDays),
                ]);
            }
        }
    }
}
