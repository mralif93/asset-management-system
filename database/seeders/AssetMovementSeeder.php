<?php

namespace Database\Seeders;

use App\Models\AssetMovement;
use App\Models\Asset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::all();
        $users = User::all();
        $adminUsers = User::where('role', 'admin')->get();

        if ($assets->isEmpty()) {
            $this->command->warn('No assets found. Please run AssetSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        // Sample movement data with different statuses
        $movements = [
            [
                'tarikh_permohonan' => Carbon::now()->subDays(11),
                'jenis_pergerakan' => 'Peminjaman',
                'lokasi_asal' => 'Pejabat Imam',
                'lokasi_destinasi' => 'Dewan Ceramah',
                'tarikh_pergerakan' => Carbon::now()->subDays(10),
                'tarikh_jangka_pulangan' => Carbon::now()->addDays(5),
                'nama_peminjam_pegawai_bertanggungjawab' => 'Ustaz Rahman bin Ali',
                'sebab_pergerakan' => 'Ceramah mingguan untuk jemaah',
                'catatan_pergerakan' => 'Peminjaman untuk ceramah Maghrib mingguan',
                'status_pergerakan' => 'diluluskan',
                'tarikh_kelulusan' => Carbon::now()->subDays(9),
            ],
            [
                'tarikh_permohonan' => Carbon::now()->subDays(21),
                'jenis_pergerakan' => 'Pemindahan',
                'lokasi_asal' => 'Bilik Stor',
                'lokasi_destinasi' => 'Ruang Solat',
                'tarikh_pergerakan' => Carbon::now()->subDays(20),
                'nama_peminjam_pegawai_bertanggungjawab' => 'Encik Mahmud bin Hassan',
                'sebab_pergerakan' => 'Keperluan harian solat jemaah',
                'catatan_pergerakan' => 'Pemindahan kekal kerusi untuk jemaah',
                'status_pergerakan' => 'diluluskan',
                'tarikh_kelulusan' => Carbon::now()->subDays(19),
            ],
            [
                'tarikh_permohonan' => Carbon::now()->subDays(1),
                'jenis_pergerakan' => 'Peminjaman',
                'lokasi_asal' => 'Ruang Tamu',
                'lokasi_destinasi' => 'Surau Kawasan Perumahan',
                'tarikh_pergerakan' => Carbon::now()->addDays(3),
                'tarikh_jangka_pulangan' => Carbon::now()->addDays(7),
                'nama_peminjam_pegawai_bertanggungjawab' => 'Siti Aisyah binti Abdullah',
                'sebab_pergerakan' => 'Program kenduri kesyukuran',
                'catatan_pergerakan' => 'Peminjaman untuk kenduri aqiqah',
                'status_pergerakan' => 'menunggu_kelulusan',
            ],
            [
                'tarikh_permohonan' => Carbon::now()->subDays(2),
                'jenis_pergerakan' => 'Peminjaman',
                'lokasi_asal' => 'Dewan Solat Utama',
                'lokasi_destinasi' => 'Kedai Pembaikan',
                'tarikh_pergerakan' => Carbon::now()->addDays(1),
                'tarikh_jangka_pulangan' => Carbon::now()->addDays(5),
                'nama_peminjam_pegawai_bertanggungjawab' => 'Syarikat Cool Air Services',
                'sebab_pergerakan' => 'Servis berkala penyaman udara',
                'catatan_pergerakan' => 'Servis berkala 6 bulan sekali',
                'status_pergerakan' => 'menunggu_kelulusan',
            ],
            [
                'tarikh_permohonan' => Carbon::now()->subDays(3),
                'jenis_pergerakan' => 'Peminjaman',
                'lokasi_asal' => 'Tempat Letak Kereta',
                'lokasi_destinasi' => 'Masjid Jamek Klang',
                'tarikh_pergerakan' => Carbon::now()->subDays(2),
                'tarikh_jangka_pulangan' => Carbon::now()->addDays(3),
                'nama_peminjam_pegawai_bertanggungjawab' => 'Encik Karim bin Osman',
                'sebab_pergerakan' => 'Misi kemanusiaan untuk mangsa banjir',
                'catatan_pergerakan' => 'Menghantar bantuan kepada mangsa banjir Selangor',
                'status_pergerakan' => 'ditolak',
                'tarikh_kelulusan' => Carbon::now()->subDays(1),
                'sebab_penolakan' => 'Kenderaan sedang dalam penyelenggaraan dan tidak selamat untuk digunakan',
            ],
            [
                'tarikh_permohonan' => Carbon::now()->subDays(1),
                'jenis_pergerakan' => 'Pemindahan',
                'lokasi_asal' => 'Bilik Mesyuarat',
                'lokasi_destinasi' => 'Dewan Majlis',
                'tarikh_pergerakan' => Carbon::now()->addDays(7),
                'nama_peminjam_pegawai_bertanggungjawab' => 'Jawatankuasa Masjid',
                'sebab_pergerakan' => 'Mesyuarat Agung Tahunan',
                'catatan_pergerakan' => 'Permohonan untuk mesyuarat agung tahunan',
                'status_pergerakan' => 'menunggu_kelulusan',
            ],
        ];

        // Create asset movements
        foreach ($movements as $index => $movementData) {
            if ($index < $assets->count()) {
                $asset = $assets[$index];
                $user = $users->random();
                $adminUser = $adminUsers->isNotEmpty() ? $adminUsers->random() : $user;

                $data = array_merge($movementData, [
                    'asset_id' => $asset->id,
                    'user_id' => $user->id,
                ]);

                // Add approval data for approved/rejected movements
                if (in_array($movementData['status_pergerakan'], ['diluluskan', 'ditolak'])) {
                    $data['diluluskan_oleh'] = $adminUser->id;
                }

                AssetMovement::create($data);
            }
        }

        // Create additional random movements for variety
        $this->createAdditionalMovements($assets, $users, $adminUsers);

        $this->command->info('Asset movements seeded successfully with different statuses!');
    }

    private function createAdditionalMovements($assets, $users, $adminUsers)
    {
        $jenisPergerakan = ['Peminjaman', 'Pemindahan', 'Pulangan'];
        $statusPergerakan = ['menunggu_kelulusan', 'diluluskan', 'ditolak'];
        $lokasi = [
            'Pejabat Imam', 'Dewan Solat Utama', 'Bilik Mesyuarat', 'Ruang Tamu', 
            'Bilik Stor', 'Dewan Ceramah', 'Ruang Kelas Tadika', 'Tempat Letak Kereta',
            'Kedai Pembaikan', 'Rumah Imam', 'Surau Kawasan', 'Dewan Majlis',
            'Bilik Wudhu', 'Ruang Perpustakaan', 'Dapur Masjid', 'Tempat Wudu'
        ];

        $sebabPenolakan = [
            'Aset sedang dalam penyelenggaraan',
            'Tarikh bertindih dengan acara lain',
            'Aset tidak sesuai untuk kegunaan yang dimohon',
            'Dokumen permohonan tidak lengkap',
            'Lokasi destinasi tidak selamat',
            'Tempoh peminjaman terlalu lama'
        ];

        for ($i = 0; $i < 20; $i++) {
            $asset = $assets->random();
            $user = $users->random();
            $adminUser = $adminUsers->isNotEmpty() ? $adminUsers->random() : $user;
            
            $jenis = $jenisPergerakan[array_rand($jenisPergerakan)];
            $status = $statusPergerakan[array_rand($statusPergerakan)];

            // Create varied dates based on status
            if ($status === 'menunggu_kelulusan') {
                $tarikhPergerakan = Carbon::now()->addDays(rand(1, 14));
                $tarikhKelulusan = null;
                $diluluskanOleh = null;
            } elseif ($status === 'diluluskan') {
                $tarikhPergerakan = Carbon::now()->subDays(rand(-7, 30));
                $tarikhKelulusan = Carbon::now()->subDays(rand(1, 5));
                $diluluskanOleh = $adminUser->id;
            } else { // ditolak
                $tarikhPergerakan = Carbon::now()->addDays(rand(1, 21));
                $tarikhKelulusan = Carbon::now()->subDays(rand(1, 3));
                $diluluskanOleh = $adminUser->id;
            }

            $tarikhJangkaPulangan = null;
            if ($jenis === 'Peminjaman') {
                $tarikhJangkaPulangan = $tarikhPergerakan->copy()->addDays(rand(1, 14));
            }

            $data = [
                'asset_id' => $asset->id,
                'user_id' => $user->id,
                'tarikh_permohonan' => $tarikhPergerakan->copy()->subDays(rand(1, 3)),
                'jenis_pergerakan' => $jenis,
                'lokasi_asal' => $lokasi[array_rand($lokasi)],
                'lokasi_destinasi' => $lokasi[array_rand($lokasi)],
                'tarikh_pergerakan' => $tarikhPergerakan,
                'tarikh_jangka_pulangan' => $tarikhJangkaPulangan,
                'nama_peminjam_pegawai_bertanggungjawab' => $user->name,
                'sebab_pergerakan' => $this->generateRandomPurpose($jenis),
                'catatan_pergerakan' => 'Data sampel untuk demonstrasi sistem',
                'status_pergerakan' => $status,
                'tarikh_kelulusan' => $tarikhKelulusan,
                'diluluskan_oleh' => $diluluskanOleh,
            ];

            // Add rejection reason for rejected movements
            if ($status === 'ditolak') {
                $data['sebab_penolakan'] = $sebabPenolakan[array_rand($sebabPenolakan)];
            }

            AssetMovement::create($data);
        }
    }

    private function generateRandomPurpose($jenis)
    {
        $purposes = [
            'Peminjaman' => [
                'Program ceramah mingguan',
                'Majlis kenduri aqiqah',
                'Kelas mengaji al-Quran',
                'Mesyuarat jawatankuasa',
                'Program gotong-royong',
                'Majlis berbuka puasa',
                'Program hari raya',
                'Kelas khas ramadan',
                'Majlis perkahwinan',
                'Program khatan',
                'Ceramah motivasi',
                'Kursus kewangan Islam'
            ],
            'Pemindahan' => [
                'Keperluan harian solat jemaah',
                'Penambahbaikan kemudahan',
                'Penyusunan semula ruang',
                'Keperluan pentadbiran',
                'Penggantian lokasi lama',
                'Peningkatan keselamatan',
                'Optimasi penggunaan ruang'
            ],
            'Pulangan' => [
                'Tamat tempoh peminjaman',
                'Selesai program',
                'Tidak lagi diperlukan',
                'Penyelenggaraan berkala',
                'Pemulangan awal'
            ],
        ];

        $purposeList = $purposes[$jenis] ?? ['Keperluan am'];
        return $purposeList[array_rand($purposeList)];
    }
}
