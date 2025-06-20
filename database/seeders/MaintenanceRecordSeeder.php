<?php

namespace Database\Seeders;

use App\Models\MaintenanceRecord;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MaintenanceRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::all();

        // Sample maintenance records
        $maintenanceRecords = [
            [
                'tarikh_penyelenggaraan' => Carbon::now()->subDays(60),
                'jenis_penyelenggaraan' => 'Penyelenggaraan Pencegahan',
                'butiran_kerja' => 'Pembersihan dalaman, kemas kini sistem operasi, scan virus',
                'nama_syarikat_kontraktor' => 'IT Solutions Sdn Bhd',
                'kos_penyelenggaraan' => 150.00,
                'status_penyelenggaraan' => 'Selesai',
                'pegawai_bertanggungjawab' => 'Ustaz Ahmad bin Ali',
                'catatan' => 'Servis rutin 6 bulan sekali',
            ],
            [
                'tarikh_penyelenggaraan' => Carbon::now()->subDays(45),
                'jenis_penyelenggaraan' => 'Pembersihan',
                'butiran_kerja' => 'Cuci bersih kerusi, gosok dan polish',
                'nama_syarikat_kontraktor' => 'Kakitangan Masjid',
                'kos_penyelenggaraan' => 0.00,
                'status_penyelenggaraan' => 'Selesai',
                'pegawai_bertanggungjawab' => 'Encik Mahmud bin Hassan',
                'catatan' => 'Pembersihan mingguan rutin',
            ],
            [
                'tarikh_penyelenggaraan' => Carbon::now()->subDays(15),
                'jenis_penyelenggaraan' => 'Penyelenggaraan Korektif',
                'butiran_kerja' => 'Tukar filter udara, bersih evaporator, check gas freon',
                'nama_syarikat_kontraktor' => 'Cool Air Services Sdn Bhd',
                'kos_penyelenggaraan' => 280.00,
                'status_penyelenggaraan' => 'Selesai',
                'pegawai_bertanggungjawab' => 'Ustaz Ahmad bin Ali',
                'catatan' => 'Filter tersumbat, suara bising',
            ],
            [
                'tarikh_penyelenggaraan' => Carbon::now()->subDays(30),
                'jenis_penyelenggaraan' => 'Pembersihan',
                'butiran_kerja' => 'Gosok permukaan meja, polish kayu jati',
                'nama_syarikat_kontraktor' => 'Kakitangan Surau',
                'kos_penyelenggaraan' => 0.00,
                'status_penyelenggaraan' => 'Selesai',
                'pegawai_bertanggungjawab' => 'Haji Ibrahim bin Yusof',
                'catatan' => 'Penjagaan rutin untuk meja kayu jati',
            ],
            [
                'tarikh_penyelenggaraan' => Carbon::now()->subDays(7),
                'jenis_penyelenggaraan' => 'Pembersihan',
                'butiran_kerja' => 'Bersih kipas, sapu habuk pada bilah kipas',
                'nama_syarikat_kontraktor' => 'Kakitangan Surau',
                'kos_penyelenggaraan' => 0.00,
                'status_penyelenggaraan' => 'Selesai',
                'pegawai_bertanggungjawab' => 'Encik Rosli bin Ahmad',
                'catatan' => 'Pembersihan mingguan kipas siling',
            ],
        ];

        // Create maintenance records for existing assets
        foreach ($maintenanceRecords as $index => $maintenanceData) {
            if ($index < $assets->count()) {
                $asset = $assets[$index];
                
                MaintenanceRecord::create(array_merge($maintenanceData, [
                    'asset_id' => $asset->id,
                ]));
            }
        }

        // Create additional random maintenance records
        $this->createAdditionalMaintenanceRecords($assets);

        $this->command->info('Maintenance records seeded successfully!');
    }

    private function createAdditionalMaintenanceRecords($assets)
    {
        $jenispenyelenggaraan = [
            'Penyelenggaraan Pencegahan',
            'Penyelenggaraan Korektif', 
            'Pembersihan',
            'Pembaikan',
            'Penggantian Bahagian'
        ];

        $statusPenyelenggaraan = ['Selesai', 'Dalam Proses', 'Dijadualkan', 'Dibatalkan'];

        $syarikatKontraktor = [
            'Kakitangan Masjid',
            'Kakitangan Surau', 
            'IT Solutions Sdn Bhd',
            'Cool Air Services Sdn Bhd',
            'Ahmad Electrical Services',
            'Sinar Jaya Maintenance',
            'Bestari Technical Services',
            'Pro-Tech Solutions',
            'Mega Facilities Sdn Bhd',
            'Elite Maintenance Services'
        ];

        $pegawaiBertanggungjawab = [
            'Ustaz Ahmad bin Ali',
            'Haji Ibrahim bin Yusof',
            'Encik Mahmud bin Hassan',
            'Encik Rosli bin Ahmad',
            'Ustaz Rahman bin Omar',
            'Haji Abdullah bin Yusof'
        ];

        // Detailed work descriptions based on maintenance type
        $butiranKerja = [
            'Penyelenggaraan Pencegahan' => [
                'Pembersihan dalaman dan luaran, pemeriksaan komponen',
                'Servis berkala mengikut jadual pengilang',
                'Pemeriksaan keselamatan dan fungsi',
                'Kalibrasi dan penalaan sistem',
                'Pemeriksaan visual dan ujian prestasi'
            ],
            'Penyelenggaraan Korektif' => [
                'Pembaikan kerosakan yang dikesan',
                'Penggantian bahagian yang rosak',
                'Penyelesaian masalah teknikal',
                'Pembetulan fungsi yang tidak normal',
                'Tindakan pembaikan segera'
            ],
            'Pembersihan' => [
                'Pembersihan menyeluruh dalaman dan luaran',
                'Penyingkiran habuk dan kotoran',
                'Pembersihan dan pengilap permukaan',
                'Sanitasi dan pembersihan berkala',
                'Cuci dan gosok mengikut keperluan'
            ],
            'Pembaikan' => [
                'Pembaikan komponen yang rosak',
                'Penyelesaian masalah mekanikal',
                'Pembaikan sistem elektrik',
                'Tukaran bahagian spare part',
                'Pemulihan fungsi asal'
            ],
            'Penggantian Bahagian' => [
                'Penggantian bahagian yang sudah haus',
                'Tukaran komponen yang mencapai akhir hayat',
                'Upgrade bahagian kepada yang lebih baik',
                'Penggantian mengikut jadual pencegahan',
                'Tukaran bahagian yang tidak boleh dibaiki'
            ]
        ];

        // Create 2-4 maintenance records per asset
        foreach ($assets as $asset) {
            $numRecords = rand(2, 4);
            
            for ($i = 0; $i < $numRecords; $i++) {
                $jenis = $jenispenyelenggaraan[array_rand($jenispenyelenggaraan)];
                $status = $statusPenyelenggaraan[array_rand($statusPenyelenggaraan)];
                $tarikhPenyelenggaraan = Carbon::now()->subDays(rand(1, 180));
                
                // Determine contractor based on maintenance type
                $kontraktor = $syarikatKontraktor[array_rand($syarikatKontraktor)];
                if ($jenis === 'Pembersihan') {
                    $kontraktor = rand(0, 1) ? 'Kakitangan Masjid' : 'Kakitangan Surau';
                }

                // Calculate cost based on type and contractor
                $kos = 0.00;
                if (!in_array($kontraktor, ['Kakitangan Masjid', 'Kakitangan Surau'])) {
                    $kos = match($jenis) {
                        'Penyelenggaraan Pencegahan' => rand(100, 300),
                        'Penyelenggaraan Korektif' => rand(150, 500),
                        'Pembaikan' => rand(200, 800),
                        'Penggantian Bahagian' => rand(250, 1000),
                        default => rand(50, 200)
                    };
                }

                MaintenanceRecord::create([
                    'asset_id' => $asset->id,
                    'tarikh_penyelenggaraan' => $tarikhPenyelenggaraan,
                    'jenis_penyelenggaraan' => $jenis,
                    'butiran_kerja' => $butiranKerja[$jenis][array_rand($butiranKerja[$jenis])],
                    'nama_syarikat_kontraktor' => $kontraktor,
                    'kos_penyelenggaraan' => $kos,
                    'status_penyelenggaraan' => $status,
                    'pegawai_bertanggungjawab' => $pegawaiBertanggungjawab[array_rand($pegawaiBertanggungjawab)],
                    'catatan' => $this->generateMaintenanceNote($jenis, $status),
                ]);
            }
        }
    }

    private function generateMaintenanceNote($jenis, $status)
    {
        $notes = [
            'Penyelenggaraan Pencegahan' => [
                'Selesai' => [
                    'Servis berkala mengikut jadual, semua komponen dalam keadaan baik',
                    'Pemeriksaan rutin selesai, tiada masalah ditemui',
                    'Penyelenggaraan pencegahan berjaya dilaksanakan'
                ],
                'Dalam Proses' => [
                    'Sedang menjalani servis berkala',
                    'Proses pemeriksaan komponen masih berjalan'
                ],
                'Dijadualkan' => [
                    'Dijadualkan untuk servis berkala akan datang',
                    'Menunggu jadual kontraktor'
                ]
            ],
            'Pembersihan' => [
                'Selesai' => [
                    'Pembersihan menyeluruh selesai dilakukan',
                    'Aset kini dalam keadaan bersih dan siap digunakan',
                    'Pembersihan rutin mengikut jadual'
                ]
            ],
            'default' => [
                'Selesai' => ['Kerja penyelenggaraan telah selesai dilaksanakan'],
                'Dalam Proses' => ['Kerja penyelenggaraan sedang berjalan'],
                'Dijadualkan' => ['Dijadualkan untuk penyelenggaraan akan datang']
            ]
        ];

        $categoryNotes = $notes[$jenis] ?? $notes['default'];
        $statusNotes = $categoryNotes[$status] ?? $categoryNotes['Selesai'] ?? ['Tiada catatan khusus'];
        
        return $statusNotes[array_rand($statusNotes)];
    }
}
