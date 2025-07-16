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
                'tarikh_laporan' => Carbon::now()->subDays(30),
                'jenis_kejadian' => 'Kecurian',
                'sebab_kejadian' => 'Pecah Masuk',
                'butiran_kejadian' => 'Komputer hilang setelah pecah rumah pada waktu malam. Kaca tingkap dipecahkan dan komputer dicuri.',
                'pegawai_pelapor' => 'Ustaz Ahmad bin Ali',
                'status_kejadian' => 'Dilaporkan',
                'laporan_polis' => 'IPD Shah Alam No: SA2024081500123',
                'nilai_kehilangan' => 2500.00,
                'catatan' => 'Kes pecah rumah pada 15/8/2024, laporan polis dibuat, sistem keselamatan dipertingkatkan. Status tuntutan insurans: Dituntut.',
            ],
            [
                'tarikh_laporan' => Carbon::now()->subDays(25),
                'jenis_kejadian' => 'Kerosakan',
                'sebab_kejadian' => 'Kerosakan Tidak Boleh Dibaiki',
                'butiran_kejadian' => 'Kerusi rosak teruk selepas digunakan untuk majlis. Struktur kerusi patah dan tidak boleh dibaiki.',
                'pegawai_pelapor' => 'Encik Mahmud bin Hassan',
                'status_kejadian' => 'Dilaporkan',
                'nilai_kehilangan' => 150.00,
                'catatan' => 'Kerusi telah mencapai jangka hayat penggunaan, perlu diganti dengan yang baru.',
            ],
            [
                'tarikh_laporan' => Carbon::now()->subDays(20),
                'jenis_kejadian' => 'Kerosakan',
                'sebab_kejadian' => 'Kerosakan Elektrik',
                'butiran_kejadian' => 'Penyaman udara rosak teruk selepas kilat sambar. Sistem elektrik terbakar.',
                'pegawai_pelapor' => 'Ustaz Ahmad bin Ali',
                'status_kejadian' => 'Dilaporkan',
                'nilai_kehilangan' => 3200.00,
                'catatan' => 'Menunggu laporan teknikal dan anggaran pembaikan. Status tuntutan insurans: Dalam proses.',
            ],
        ];

        // Create loss/writeoff records
        foreach ($lossWriteoffs as $index => $recordData) {
            if ($index < $assets->count()) {
                $asset = $assets[$index];
                
                LossWriteoff::create(array_merge($recordData, [
                    'asset_id' => $asset->id,
                ]));

                // Update asset status if approved
                if ($recordData['status_kejadian'] === 'Diluluskan') {
                    $asset->update(['status_aset' => 'Dilupuskan']);
                }
            }
        }

        // Create additional sample records
        $this->createAdditionalRecords();

        $this->command->info('Loss/writeoff records seeded successfully!');
    }

    private function createAdditionalRecords()
    {
        // Get some assets for additional records
        $assets = Asset::where('status_aset', '!=', 'Dilupuskan')
                      ->limit(5)
                      ->get();

        $jenisKejadian = [
            'Kecurian',
            'Kerosakan',
            'Kebakaran',
            'Bencana Alam',
            'Vandalisme',
            'Kemalangan'
        ];

        $sebabKejadian = [
            'Kecurian' => [
                'Pecah Masuk',
                'Kecurian Semasa Operasi',
                'Kecurian Waktu Malam',
                'Rompakan'
            ],
            'Kerosakan' => [
                'Usia',
                'Penyelenggaraan',
                'Salah Guna',
                'Kerosakan Tidak Boleh Dibaiki'
            ],
            'Kebakaran' => [
                'Litar Pintas',
                'Kebakaran Berdekatan',
                'Kebakaran Kecil',
                'Kerosakan Elektrik'
            ],
            'Bencana Alam' => [
                'Banjir',
                'Ribut',
                'Tanah Runtuh',
                'Hujan Lebat'
            ],
            'Vandalisme' => [
                'Kerosakan Sengaja',
                'Vandalisme',
                'Penyalahgunaan',
                'Kerosakan Disengajakan'
            ],
            'Kemalangan' => [
                'Terjatuh',
                'Kemalangan Pengendalian',
                'Kemalangan Penggunaan',
                'Kerosakan Tidak Sengaja'
            ]
        ];

        $pegawaiPelapor = [
            'Ustaz Ahmad bin Ali',
            'Haji Ibrahim bin Yusof',
            'Encik Mahmud bin Hassan',
            'Encik Rosli bin Ahmad',
            'Ustaz Rahman bin Omar'
        ];

        $statusKejadian = ['Dilaporkan', 'Dalam Siasatan', 'Diluluskan'];

        foreach ($assets as $asset) {
            $jenis = $jenisKejadian[array_rand($jenisKejadian)];
            $status = $statusKejadian[array_rand($statusKejadian)];
            $tarikhLaporan = Carbon::now()->subDays(rand(5, 180));

            $record = [
                'asset_id' => $asset->id,
                'tarikh_laporan' => $tarikhLaporan,
                'jenis_kejadian' => $jenis,
                'sebab_kejadian' => $sebabKejadian[$jenis][array_rand($sebabKejadian[$jenis])],
                'butiran_kejadian' => $this->generateButiranKejadian($jenis),
                'pegawai_pelapor' => $pegawaiPelapor[array_rand($pegawaiPelapor)],
                'status_kejadian' => $status,
                'nilai_kehilangan' => rand(100, 5000),
                'catatan' => $this->generateCatatan($jenis, $status),
            ];

            // Add police report for theft cases
            if ($jenis === 'Kecurian') {
                $record['laporan_polis'] = 'IPD/'. date('Y') . '/' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
            }

            // Add approval date if status is approved
            if ($status === 'Diluluskan') {
                $record['tarikh_kelulusan_hapus_kira'] = Carbon::parse($tarikhLaporan)->addDays(rand(1, 30));
            }

            LossWriteoff::create($record);

            // Update asset status if approved
            if ($status === 'Diluluskan') {
                $asset->update(['status_aset' => 'Dilupuskan']);
            }
        }
    }

    private function generateButiranKejadian($jenis)
    {
        $butiranTemplate = [
            'Kecurian' => [
                'Aset hilang semasa waktu operasi. Tiada tanda-tanda kekerasan.',
                'Aset dicuri semasa premis kosong. Terdapat tanda-tanda pecah masuk.',
                'Kehilangan dilaporkan oleh staf selepas waktu operasi.',
                'Kecurian berlaku semasa pecah masuk pada waktu malam.'
            ],
            'Kerosakan' => [
                'Kerosakan disebabkan penggunaan biasa dan usia aset.',
                'Kerosakan akibat penyelenggaraan yang tidak mencukupi.',
                'Rosak akibat salah pengendalian oleh pengguna.',
                'Kerosakan tidak boleh dibaiki dan memerlukan penggantian.'
            ],
            'Kebakaran' => [
                'Terbakar akibat litar pintas pada sistem elektrik.',
                'Kerosakan akibat kebakaran yang berlaku berdekatan.',
                'Musnah dalam kebakaran kecil di bahagian stor.',
                'Kerosakan akibat asap dan haba dari kebakaran.'
            ],
            'Bencana Alam' => [
                'Kerosakan akibat banjir yang melanda kawasan.',
                'Kerosakan akibat ribut kuat dan hujan lebat.',
                'Kerosakan akibat tanah runtuh di kawasan belakang.',
                'Kerosakan akibat hujan lebat dan banjir kilat.'
            ],
            'Vandalisme' => [
                'Kerosakan disengajakan oleh pihak tidak dikenali.',
                'Vandalisme dilaporkan oleh staf keselamatan.',
                'Kerosakan akibat penyalahgunaan oleh orang awam.',
                'Kerosakan disengajakan dikesan pada waktu pagi.'
            ],
            'Kemalangan' => [
                'Kerosakan akibat terjatuh semasa pengendalian.',
                'Kerosakan semasa aktiviti penyelenggaraan.',
                'Kemalangan semasa penggunaan normal.',
                'Kerosakan tidak sengaja semasa penggunaan.'
            ]
        ];

        return $butiranTemplate[$jenis][array_rand($butiranTemplate[$jenis])];
    }

    private function generateCatatan($jenis, $status)
    {
        $catatan = '';
        
        switch ($status) {
            case 'Dilaporkan':
                $catatan = 'Laporan awal diterima. ';
                break;
            case 'Dalam Siasatan':
                $catatan = 'Siasatan sedang dijalankan. ';
                break;
            case 'Diluluskan':
                $catatan = 'Permohonan hapus kira telah diluluskan. ';
                break;
        }

        switch ($jenis) {
            case 'Kecurian':
                $catatan .= 'Status siasatan polis: Dalam siasatan. ';
                break;
            case 'Kerosakan':
                $catatan .= 'Menunggu laporan teknikal lengkap. ';
                break;
            case 'Kebakaran':
                $catatan .= 'Tuntutan insurans dalam proses. ';
                break;
            case 'Bencana Alam':
                $catatan .= 'Dokumentasi untuk insurans sedang disediakan. ';
                break;
            case 'Vandalisme':
                $catatan .= 'Langkah keselamatan tambahan akan dilaksanakan. ';
                break;
            case 'Kemalangan':
                $catatan .= 'Prosedur pengendalian akan dikaji semula. ';
                break;
        }

        return $catatan;
    }
}
