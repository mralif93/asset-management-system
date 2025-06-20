<?php

namespace Database\Seeders;

use App\Models\MasjidSurau;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasjidSurauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masjidSuraus = [
            [
                'nama' => 'Masjid Tengku Ampuan Jemaah',
                'jenis' => 'Masjid',
                'alamat' => 'Jalan Sultan Abdul Aziz Shah, Bukit Jelutong',
                'poskod' => '40150',
                'bandar' => 'Shah Alam',
                'negeri' => 'Selangor',
                'telefon' => '03-78461234',
                'email' => 'mtaj@gmail.com',
                'imam_ketua' => 'Ustaz Ahmad bin Abdullah',
                'bilangan_jemaah' => 500,
                'tahun_dibina' => 1995,
                'status' => 'Aktif',
                'catatan' => 'Masjid utama kawasan Bukit Jelutong dengan kapasiti jemaah yang besar.',
            ],
            [
                'nama' => 'Surau At-Taqwa',
                'jenis' => 'Surau',
                'alamat' => 'Taman Bukit Jelutong',
                'poskod' => '40150',
                'bandar' => 'Shah Alam',
                'negeri' => 'Selangor',
                'telefon' => '03-78461235',
                'email' => 'attaqwa@gmail.com',
                'imam_ketua' => 'Encik Mohd Ali bin Hassan',
                'bilangan_jemaah' => 150,
                'tahun_dibina' => 2005,
                'status' => 'Aktif',
                'catatan' => 'Surau komuniti untuk penduduk Taman Bukit Jelutong.',
            ],
            [
                'nama' => 'Masjid Al-Hidayah',
                'jenis' => 'Masjid',
                'alamat' => 'Seksyen 3',
                'poskod' => '40000',
                'bandar' => 'Shah Alam',
                'negeri' => 'Selangor',
                'telefon' => '03-55121234',
                'email' => 'alhidayah@gmail.com',
                'imam_ketua' => 'Ustaz Ibrahim bin Yusuf',
                'bilangan_jemaah' => 800,
                'tahun_dibina' => 1980,
                'status' => 'Aktif',
                'catatan' => 'Masjid bersejarah di Seksyen 3 Shah Alam.',
            ],
            [
                'nama' => 'Surau An-Nur',
                'jenis' => 'Surau',
                'alamat' => 'Bandar Baru Klang',
                'poskod' => '41150',
                'bandar' => 'Klang',
                'negeri' => 'Selangor',
                'telefon' => '03-33451234',
                'email' => 'annur@gmail.com',
                'imam_ketua' => 'Encik Zainal bin Ahmad',
                'bilangan_jemaah' => 200,
                'tahun_dibina' => 2010,
                'status' => 'Aktif',
                'catatan' => 'Surau moden dengan kemudahan lengkap.',
            ],
            [
                'nama' => 'Masjid Jamek Petaling Jaya',
                'jenis' => 'Masjid',
                'alamat' => 'Seksyen 14',
                'poskod' => '46100',
                'bandar' => 'Petaling Jaya',
                'negeri' => 'Selangor',
                'telefon' => '03-79551234',
                'email' => 'mjpj@gmail.com',
                'imam_ketua' => 'Ustaz Rahman bin Omar',
                'bilangan_jemaah' => 600,
                'tahun_dibina' => 1975,
                'status' => 'Aktif',
                'catatan' => 'Masjid jamek utama Petaling Jaya dengan sejarah panjang.',
            ],
            [
                'nama' => 'Surau Ar-Rahman',
                'jenis' => 'Surau',
                'alamat' => 'Taman Subang Jaya',
                'poskod' => '47500',
                'bandar' => 'Subang Jaya',
                'negeri' => 'Selangor',
                'telefon' => '03-56331234',
                'email' => 'arrahman@gmail.com',
                'imam_ketua' => 'Encik Rashid bin Mahmud',
                'bilangan_jemaah' => 120,
                'tahun_dibina' => 2015,
                'status' => 'Aktif',
                'catatan' => 'Surau baharu dengan reka bentuk moden.',
            ],
            [
                'nama' => 'Masjid Negara',
                'jenis' => 'Masjid',
                'alamat' => 'Jalan Perdana',
                'poskod' => '50480',
                'bandar' => 'Kuala Lumpur',
                'negeri' => 'Wilayah Persekutuan Kuala Lumpur',
                'telefon' => '03-26935435',
                'email' => 'masjidn@gmail.com',
                'imam_ketua' => 'Dato\' Ustaz Hasan bin Ali',
                'bilangan_jemaah' => 15000,
                'tahun_dibina' => 1965,
                'status' => 'Aktif',
                'catatan' => 'Masjid kebangsaan Malaysia dengan seni bina yang unik.',
            ],
            [
                'nama' => 'Surau Al-Ikhlas',
                'jenis' => 'Surau',
                'alamat' => 'Kampung Baru',
                'poskod' => '50300',
                'bandar' => 'Kuala Lumpur',
                'negeri' => 'Wilayah Persekutuan Kuala Lumpur',
                'telefon' => '03-26921234',
                'email' => 'alikhlas@gmail.com',
                'imam_ketua' => 'Haji Mahmud bin Ibrahim',
                'bilangan_jemaah' => 80,
                'tahun_dibina' => 1960,
                'status' => 'Tidak Aktif',
                'catatan' => 'Surau lama yang memerlukan pembaikan.',
            ],
        ];

        foreach ($masjidSuraus as $data) {
            MasjidSurau::create($data);
        }
    }
}
