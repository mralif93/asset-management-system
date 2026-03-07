<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\Disposal;
use App\Models\Inspection;
use App\Models\LossWriteoff;
use App\Models\MaintenanceRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class IntegratedModuleScenarioSeeder extends Seeder
{
    /**
     * Seed connected end-to-end scenarios across modules.
     */
    public function run(): void
    {
        $assets = Asset::where('kategori_aset', 'asset')->orderBy('id')->get();
        $users = User::orderBy('id')->get();

        if ($assets->count() < 6 || $users->isEmpty()) {
            $this->command->warn('IntegratedModuleScenarioSeeder skipped: requires at least 6 assets and 1 user.');
            return;
        }

        // Reset module data for deterministic scenario set.
        AssetMovement::query()->delete();
        Inspection::query()->delete();
        MaintenanceRecord::query()->delete();
        Disposal::query()->delete();
        LossWriteoff::query()->delete();

        $a1 = $assets[0];
        $a2 = $assets[1];
        $a3 = $assets[2];
        $a4 = $assets[3];
        $a5 = $assets[4];
        $a6 = $assets[5];

        $admin = $users->firstWhere('role', 'administrator') ?? $users->first();
        $officer = $users->firstWhere('role', 'officer') ?? $admin;

        $fromMasjid = $a1->masjid_surau_id;
        $toMasjid = Asset::where('masjid_surau_id', '!=', $fromMasjid)->value('masjid_surau_id') ?? $fromMasjid;

        // Scenario 1: Approved movement + returned + healthy inspection + completed maintenance.
        AssetMovement::create([
            'asset_id' => $a1->id,
            'user_id' => $officer->id,
            'kuantiti' => 1,
            'origin_masjid_surau_id' => $fromMasjid,
            'destination_masjid_surau_id' => $toMasjid,
            'tarikh_permohonan' => Carbon::now()->subDays(20),
            'jenis_pergerakan' => 'Peminjaman',
            'lokasi_asal_spesifik' => $a1->lokasi_penempatan ?? 'Stor Utama',
            'lokasi_destinasi_spesifik' => 'Dewan Program',
            'nama_peminjam_pegawai_bertanggungjawab' => $officer->name,
            'tujuan_pergerakan' => 'Program komuniti hujung minggu',
            'tarikh_pergerakan' => Carbon::now()->subDays(18),
            'tarikh_jangka_pulang' => Carbon::now()->subDays(12),
            'tarikh_pulang_sebenar' => Carbon::now()->subDays(12),
            'status_pergerakan' => 'dipulangkan',
            'pegawai_meluluskan' => $admin->name,
            'catatan' => 'Selesai tanpa isu.',
        ]);

        Inspection::create([
            'asset_id' => $a1->id,
            'user_id' => $officer->id,
            'tarikh_pemeriksaan' => Carbon::now()->subDays(10),
            'kondisi_aset' => 'Sedang Digunakan',
            'lokasi_semasa_pemeriksaan' => $a1->lokasi_penempatan ?? 'Stor Utama',
            'cadangan_tindakan' => 'Tiada Tindakan',
            'pegawai_pemeriksa' => $officer->name,
            'jawatan_pemeriksa' => $officer->position ?? 'Pegawai Aset',
            'catatan_pemeriksa' => 'Aset dalam keadaan baik selepas dipulangkan.',
        ]);

        MaintenanceRecord::create([
            'asset_id' => $a1->id,
            'user_id' => $officer->id,
            'tarikh_penyelenggaraan' => Carbon::now()->subDays(9),
            'jenis_penyelenggaraan' => 'Pencegahan',
            'butiran_kerja' => 'Pembersihan menyeluruh dan semakan fungsi.',
            'penyedia_perkhidmatan' => 'Unit Penyelenggaraan Dalaman',
            'kos_penyelenggaraan' => 120.00,
            'status_penyelenggaraan' => 'Selesai',
            'pegawai_bertanggungjawab' => $officer->name,
            'catatan' => 'Jadual berkala dipatuhi.',
        ]);

        // Scenario 2: Inspection detects issue, maintenance in progress.
        Inspection::create([
            'asset_id' => $a2->id,
            'user_id' => $officer->id,
            'tarikh_pemeriksaan' => Carbon::now()->subDays(8),
            'kondisi_aset' => 'Rosak',
            'lokasi_semasa_pemeriksaan' => $a2->lokasi_penempatan ?? 'Bilik Operasi',
            'cadangan_tindakan' => 'Penyelenggaraan',
            'pegawai_pemeriksa' => $officer->name,
            'jawatan_pemeriksa' => $officer->position ?? 'Pegawai Aset',
            'catatan_pemeriksa' => 'Komponen utama menunjukkan tanda kehausan.',
        ]);

        MaintenanceRecord::create([
            'asset_id' => $a2->id,
            'user_id' => $officer->id,
            'tarikh_penyelenggaraan' => Carbon::now()->subDays(6),
            'tarikh_penyelenggaraan_akan_datang' => Carbon::now()->addDays(14),
            'jenis_penyelenggaraan' => 'Pembaikan',
            'butiran_kerja' => 'Penggantian komponen rosak dan ujian fungsi.',
            'penyedia_perkhidmatan' => 'Syarikat Servis Teknikal Maju',
            'kos_penyelenggaraan' => 480.00,
            'status_penyelenggaraan' => 'Dalam Proses',
            'pegawai_bertanggungjawab' => $officer->name,
            'catatan' => 'Menunggu alat ganti.',
        ]);

        // Scenario 3: Disposal requested and approved.
        Inspection::create([
            'asset_id' => $a3->id,
            'user_id' => $officer->id,
            'tarikh_pemeriksaan' => Carbon::now()->subDays(15),
            'kondisi_aset' => 'Rosak',
            'lokasi_semasa_pemeriksaan' => $a3->lokasi_penempatan ?? 'Stor Lupus',
            'cadangan_tindakan' => 'Pelupusan',
            'pegawai_pemeriksa' => $officer->name,
            'jawatan_pemeriksa' => $officer->position ?? 'Pegawai Aset',
            'catatan_pemeriksa' => 'Tidak ekonomik untuk dibaiki.',
        ]);

        Disposal::create([
            'asset_id' => $a3->id,
            'kuantiti' => 1,
            'tarikh_permohonan' => Carbon::now()->subDays(14),
            'justifikasi_pelupusan' => 'tidak_ekonomi',
            'kaedah_pelupusan_dicadang' => 'jualan',
            'kaedah_pelupusan' => 'jualan',
            'status_pelupusan' => 'Diluluskan',
            'pegawai_pemohon' => $officer->name,
            'tarikh_kelulusan_pelupusan' => Carbon::now()->subDays(11),
            'tarikh_pelupusan' => Carbon::now()->subDays(9),
            'nombor_mesyuarat_jawatankuasa' => 'JWK/SCN/001',
            'tempat_pelupusan' => 'Lelongan Terbuka',
            'hasil_pelupusan' => 350.00,
            'nilai_pelupusan' => $a3->nilai_perolehan ?? 0,
            'nilai_baki' => $a3->getCurrentValue(),
            'catatan' => 'Diluluskan untuk pelupusan selepas semakan teknikal.',
            'user_id' => $officer->id,
        ]);
        $a3->update(['status_aset' => Asset::STATUS_DISPOSED]);

        // Scenario 4: Loss reported and approved as write-off.
        LossWriteoff::create([
            'asset_id' => $a4->id,
            'user_id' => $officer->id,
            'kuantiti_kehilangan' => 1,
            'tarikh_laporan' => Carbon::now()->subDays(7),
            'tarikh_kehilangan' => Carbon::now()->subDays(8),
            'jenis_kejadian' => 'hilang',
            'sebab_kejadian' => 'kecurian',
            'butiran_kejadian' => 'Kehilangan semasa aktiviti luar premis.',
            'pegawai_pelapor' => $officer->name,
            'nilai_kehilangan' => $a4->nilai_perolehan ?? 0,
            'laporan_polis' => 'IPD/2026/0031',
            'status_kejadian' => 'Diluluskan',
            'tarikh_kelulusan_hapus_kira' => Carbon::now()->subDays(4),
            'diluluskan_oleh' => $admin->id,
            'catatan' => 'Hapus kira diluluskan oleh jawatankuasa.',
        ]);
        $a4->update(['status_aset' => Asset::STATUS_LOST]);

        // Scenario 5: Pending approvals queue examples.
        AssetMovement::create([
            'asset_id' => $a5->id,
            'user_id' => $officer->id,
            'kuantiti' => 1,
            'origin_masjid_surau_id' => $a5->masjid_surau_id,
            'destination_masjid_surau_id' => $toMasjid,
            'tarikh_permohonan' => Carbon::now()->subDays(2),
            'jenis_pergerakan' => 'Pemindahan',
            'lokasi_asal_spesifik' => $a5->lokasi_penempatan ?? 'Stor A',
            'lokasi_destinasi_spesifik' => 'Bilik Mesyuarat',
            'nama_peminjam_pegawai_bertanggungjawab' => $officer->name,
            'tujuan_pergerakan' => 'Penyusunan semula ruang operasi',
            'tarikh_pergerakan' => Carbon::now()->addDays(1),
            'status_pergerakan' => 'menunggu_kelulusan',
            'catatan' => 'Menunggu kelulusan pihak pentadbir.',
        ]);

        Disposal::create([
            'asset_id' => $a6->id,
            'kuantiti' => 1,
            'tarikh_permohonan' => Carbon::now()->subDay(),
            'justifikasi_pelupusan' => 'usang',
            'kaedah_pelupusan_dicadang' => 'buangan',
            'status_pelupusan' => 'Dimohon',
            'pegawai_pemohon' => $officer->name,
            'nilai_pelupusan' => $a6->nilai_perolehan ?? 0,
            'nilai_baki' => $a6->getCurrentValue(),
            'catatan' => 'Permohonan baru menunggu keputusan.',
            'user_id' => $officer->id,
        ]);

        LossWriteoff::create([
            'asset_id' => $a5->id,
            'user_id' => $officer->id,
            'kuantiti_kehilangan' => 1,
            'tarikh_laporan' => Carbon::now()->subDay(),
            'tarikh_kehilangan' => Carbon::now()->subDays(2),
            'jenis_kejadian' => 'hapus_kira',
            'sebab_kejadian' => 'tidak_dapat_dikesan',
            'butiran_kejadian' => 'Aset tidak dapat dikesan semasa semakan stok berkala.',
            'pegawai_pelapor' => $officer->name,
            'nilai_kehilangan' => $a5->nilai_perolehan ?? 0,
            'status_kejadian' => 'Dilaporkan',
            'catatan' => 'Menunggu siasatan lanjut.',
        ]);

        $this->command->info('Integrated scenarios seeded:');
        $this->command->line('1) Movement completed -> Inspection good -> Maintenance completed');
        $this->command->line('2) Inspection issue -> Maintenance in progress');
        $this->command->line('3) Disposal workflow approved');
        $this->command->line('4) Loss/write-off approved');
        $this->command->line('5) Pending queue (movement/disposal/loss)');
    }
}

