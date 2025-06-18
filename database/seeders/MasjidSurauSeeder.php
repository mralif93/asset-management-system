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
                'singkatan_nama' => 'MTAJ',
                'alamat' => 'Jalan Sultan Abdul Aziz Shah, Bukit Jelutong, 40150 Shah Alam, Selangor',
                'daerah' => 'Shah Alam',
                'no_telefon' => '03-78461234',
                'email' => 'mtaj@gmail.com',
                'status' => 'Aktif',
            ],
            [
                'nama' => 'Surau At Taqwa',
                'singkatan_nama' => 'SAT',
                'alamat' => 'Taman Bukit Jelutong, 40150 Shah Alam, Selangor',
                'daerah' => 'Shah Alam',
                'no_telefon' => '03-78461235',
                'email' => 'sat@gmail.com',
                'status' => 'Aktif',
            ],
            [
                'nama' => 'Masjid Al-Hidayah',
                'singkatan_nama' => 'MAH',
                'alamat' => 'Seksyen 3, 40000 Shah Alam, Selangor',
                'daerah' => 'Shah Alam',
                'no_telefon' => '03-55121234',
                'email' => 'alhidayah@gmail.com',
                'status' => 'Aktif',
            ],
            [
                'nama' => 'Surau An-Nur',
                'singkatan_nama' => 'SAN',
                'alamat' => 'Bandar Baru Klang, 41150 Klang, Selangor',
                'daerah' => 'Klang',
                'no_telefon' => '03-33451234',
                'email' => 'annur@gmail.com',
                'status' => 'Aktif',
            ],
            [
                'nama' => 'Masjid Jamek Petaling Jaya',
                'singkatan_nama' => 'MJPJ',
                'alamat' => 'Seksyen 14, 46100 Petaling Jaya, Selangor',
                'daerah' => 'Petaling',
                'no_telefon' => '03-79551234',
                'email' => 'mjpj@gmail.com',
                'status' => 'Aktif',
            ],
        ];

        foreach ($masjidSuraus as $data) {
            MasjidSurau::create($data);
        }
    }
}
