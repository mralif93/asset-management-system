<?php

namespace App\Helpers;

class SystemData
{
    public const VALID_LOCATIONS = [
        'Anjung kiri',
        'Anjung kanan',
        'Anjung Depan(Ruang Pengantin)',
        'Ruang Utama (tingkat atas, tingkat bawah)',
        'Bilik Mesyuarat',
        'Bilik Kuliah',
        'Bilik Bendahari',
        'Bilik Setiausaha',
        'Bilik Nazir & Imam',
        'Bangunan Jenazah',
        'Tempat Letak Kenderaan',
        'Bilik pengurusan',
        'Bilik pejabat',
        'Bilik store',
        'Kawasan Letak Kereta & Motor',
        'Dapur',
        'Barangan Stor Dapur', // New location
        'Lain-lain'
    ];

    public const ACQUISITION_SOURCES = [
        'Pembelian',
        'Sumbangan',
        'Hibah',
        'Wakaf',
        'Infaq',
        'Derma',
        'Lain-lain'
    ];

    public const PHYSICAL_CONDITIONS = [
        'Cemerlang',
        'Baik',
        'Sederhana',
        'Rosak',
        'Tidak Boleh Digunakan'
    ];

    public static function getValidLocations(): array
    {
        return self::VALID_LOCATIONS;
    }

    public static function getAcquisitionSources(): array
    {
        return self::ACQUISITION_SOURCES;
    }

    public static function getPhysicalConditions(): array
    {
        return self::PHYSICAL_CONDITIONS;
    }
}
