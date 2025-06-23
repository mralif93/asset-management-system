<?php

namespace Database\Seeders;

use App\Models\LossWriteoff;
use App\Models\Asset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LossWriteoffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::where('status_aset', '!=', 'Dilupuskan')->limit(3)->get();
        $users = User::all();

        // Sample loss/writeoff records
        $lossWriteoffs = [
            [
                'tarikh_laporan' => Carbon::now()->subDays(120),
                'jenis_kejadian' => 'Kecurian',
                'sebab_kejadian' => 'Pecah Rumah',
                'butiran_kejadian' => 'Komputer hilang setelah pecah rumah pada waktu malam. Kaca tingkap dipecahkan dan komputer dicuri.',
                'pegawai_pelapor' => 'Ustaz Ahmad bin Ali',
                'nilai_kehilangan' => 2500.00,
                'laporan_polis' => 'IPD Shah Alam No: SA2024081500123',
                'tarikh_kelulusan_hapus_kira' => Carbon::now()->subDays(100),
                'status_kejadian' => 'Diluluskan',
                'catatan' => 'Kes pecah rumah pada 15/8/2024, laporan polis dibuat, sistem keselamatan dipertingkatkan. Tindakan: Laporan polis dibuat, sistem keselamatan dipertingkatkan. Status tuntutan insurans: Dituntut.',
            ],
            [
                'tarikh_laporan' => Carbon::now()->subDays(80),
                'jenis_kejadian' => 'Kerosakan',
                'sebab_kejadian' => 'Kebakaran',
                'butiran_kejadian' => 'Kebakaran kecil di dewan solat menyebabkan 10 unit kerusi musnah sepenuhnya akibat litar pintas elektrik.',
                'pegawai_pelapor' => 'Encik Mahmud bin Hassan',
                'nilai_kehilangan' => 150.00,
                'laporan_polis' => null,
                'tarikh_kelulusan_hapus_kira' => Carbon::now()->subDays(70),
                'status_kejadian' => 'Diluluskan',
                'catatan' => 'Lokasi: Dewan Solat Utama. Tindakan: Bomba dipanggil, kerusi yang rosak dibuang. Status tuntutan insurans: Tidak Dituntut.',
            ],
            [
                'tarikh_laporan' => Carbon::now()->subDays(45),
                'jenis_kejadian' => 'Kemalangan',
                'sebab_kejadian' => 'Kegagalan Pemasangan',
                'butiran_kejadian' => 'Unit penyaman udara terjatuh semasa kerja penyelenggaraan dan rosak teruk.',
                'pegawai_pelapor' => 'Ustaz Ahmad bin Ali',
                'nilai_kehilangan' => 3200.00,
                'laporan_polis' => null,
                'tarikh_kelulusan_hapus_kira' => Carbon::now()->subDays(30),
                'status_kejadian' => 'Diluluskan',
                'catatan' => 'Lokasi: Dewan Solat Utama. Tindakan: Kontraktor bertanggungjawab, claim insurance. Status tuntutan insurans: Diluluskan.',
            ],
        ];

        // Create loss/writeoff records
        foreach ($lossWriteoffs as $index => $lossData) {
            if ($index < $assets->count()) {
                $asset = $assets[$index];
                $approver = $users->where('role', 'admin')->first() ?? $users->first();
                
                LossWriteoff::create(array_merge($lossData, [
                    'asset_id' => $asset->id,
                    'diluluskan_oleh' => $approver->id,
                ]));

                // Update asset status to lost/written off
                $asset->update(['status_aset' => 'Hilang/Dihapus Kira']);
            }
        }

        // Create additional sample loss/writeoffs
        $this->createAdditionalLossWriteoffs();

        $this->command->info('Loss/writeoff records seeded successfully!');
    }

    private function createAdditionalLossWriteoffs()
    {
        $additionalAssets = Asset::where('status_aset', 'Sedang Digunakan')->limit(2)->get();
        $users = User::all();

        $jenisKejadian = [
            'Kecurian',
            'Kehilangan',
            'Kerosakan',
            'Kemalangan',
        ];

        $sebabKejadian = [
            'Pecah Rumah', 'Kegagalan Keselamatan', 'Kebakaran', 'Kegagalan Pemasangan',
        ];

        $statusKejadian = ['Menunggu', 'Diluluskan', 'Ditolak'];

        foreach ($additionalAssets as $asset) {
            $jenis = $jenisKejadian[array_rand($jenisKejadian)];
            $sebab = $sebabKejadian[array_rand($sebabKejadian)];
            $status = $statusKejadian[array_rand($statusKejadian)];
            
            $tarikhLaporan = Carbon::now()->subDays(rand(1, 365));
            $tarikhKelulusan = null;
            $diluluskanOleh = null;
            
            if ($status === 'Diluluskan') {
                $tarikhKelulusan = $tarikhLaporan->copy()->addDays(rand(7, 30));
                $diluluskanOleh = $users->where('role', 'admin')->first()?->id ?? $users->first()->id;
            }

            $nilaiKehilangan = $asset->nilai_perolehan ?? rand(100, 5000);

            LossWriteoff::create([
                'asset_id' => $asset->id,
                'tarikh_laporan' => $tarikhLaporan,
                'jenis_kejadian' => $jenis,
                'sebab_kejadian' => $sebab,
                'butiran_kejadian' => $this->generateChronology($jenis),
                'pegawai_pelapor' => 'Pegawai ' . $users->random()->name,
                'nilai_kehilangan' => $nilaiKehilangan,
                'laporan_polis' => $jenis === 'Kecurian' ? 'LP/' . rand(1000, 9999) . '/' . date('Y') : null,
                'dokumen_kehilangan' => null,
                'tarikh_kelulusan_hapus_kira' => $tarikhKelulusan,
                'status_kejadian' => $status,
                'diluluskan_oleh' => $diluluskanOleh,
                'sebab_penolakan' => $status === 'Ditolak' ? 'Maklumat tidak mencukupi' : null,
                'catatan' => $this->generateLossNote($jenis, $sebab, $nilaiKehilangan),
            ]);

            // Update asset status if approved for writeoff
            if ($status === 'Diluluskan') {
                $asset->update(['status_aset' => 'Hilang/Dihapus Kira']);
            }
        }
    }

    private function generateChronology($jenis)
    {
        $chronologies = [
            'Kecurian' => [
                'Aset dicuri dalam insiden pecah rumah pada waktu malam',
                'Kecurian berlaku semasa tiada orang di premis',
                'Dicuri oleh individu yang tidak dikenali semasa majlis',
                'Kecurian berlaku pada waktu siang semasa premis sepi'
            ],
            'Kehilangan' => [
                'Aset hilang semasa proses pemindahan ke lokasi lain',
                'Tidak dapat ditemui setelah majlis selesai',
                'Hilang tanpa kesan setelah aktiviti pembersihan',
                'Tidak diketahui bila dan bagaimana aset hilang'
            ],
            'Kerosakan' => [
                'Rosak teruk akibat kebakaran kecil di premis',
                'Kerosakan total akibat kecuaian air bumbung',
                'Musnah akibat litar pintas elektrik',
                'Rosak sepenuhnya tidak boleh digunakan lagi'
            ],
            'Kemalangan' => [
                'Terjatuh dan pecah semasa proses pemindahan',
                'Terlanggar dan rosak semasa kerja pembinaan',
                'Kemalangan semasa kerja penyelenggaraan',
                'Rosak akibat terjatuh objek lain'
            ],
            'Bencana Alam' => [
                'Rosak akibat ribut petir yang kuat',
                'Kerosakan akibat banjir kilat',
                'Musnah dalam kebakaran hutan berdekatan',
                'Rosak akibat angin kencang'
            ],
            'Vandalisme' => [
                'Dirosakkan oleh pihak yang tidak bertanggungjawab',
                'Akti vandalisme oleh individu tidak dikenali',
                'Diconteng dan dirosakkan secara sengaja',
                'Dipecahkan dengan sengaja oleh orang yang tidak dikenali'
            ],
            'Hapus Kira' => [
                'Aset sudah mencapai akhir hayat berguna',
                'Tidak ekonomik untuk diselenggara lagi',
                'Sudah usang dan tidak sesuai digunakan',
                'Diganti dengan teknologi yang lebih baru'
            ]
        ];

        $options = $chronologies[$jenis] ?? ['Tiada butiran khusus'];
        return $options[array_rand($options)];
    }

    private function generateLossNote($jenis, $sebab, $nilaiKerugian)
    {
        $notes = [
            "Jenis: {$jenis}. Sebab: {$sebab}. Nilai kerugian: RM" . number_format($nilaiKerugian, 2),
            "Insiden {$jenis} disebabkan {$sebab}. Tindakan susulan telah diambil.",
            "Laporan {$jenis} - {$sebab}. Nilai aset yang terlibat: RM" . number_format($nilaiKerugian, 2),
            "Kejadian {$jenis} akibat {$sebab}. Langkah pencegahan akan dilaksanakan."
        ];

        return $notes[array_rand($notes)];
    }
}
