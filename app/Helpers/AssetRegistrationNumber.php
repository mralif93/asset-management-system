<?php

namespace App\Helpers;

use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssetRegistrationNumber
{
    private static $assetTypeAbbreviations = [
        'Harta Modal' => 'HM',
        'Inventori' => 'I',
        'Peralatan' => 'P',
        'Kenderaan' => 'K',
        'Perabot' => 'PR',
        'Elektronik' => 'E',
        'Buku' => 'B',
        'Pakaian' => 'PK',
    ];

    /**
     * Generate asset registration number according to Selangor guidelines
     * Format: [Singkatan Nama]/[Jenis Aset]/[Tahun]/[Nombor Urutan]
     * Example: MTAJ/HM/23/001
     */
    public static function generate($masjidSurauId, $jenisAset, $year = null)
    {
        $year = $year ?: date('y'); // Get last 2 digits of year
        
        // Get mosque/surau abbreviation
        $masjidSurau = MasjidSurau::findOrFail($masjidSurauId);
        $singkatan = $masjidSurau->singkatan_nama;
        
        // Get asset type abbreviation
        $jenisAsetCode = self::$assetTypeAbbreviations[$jenisAset] ?? 'O';
        
        // Get next sequence number
        $sequenceNumber = self::getNextSequenceNumber($jenisAsetCode, $masjidSurauId, $year);
        
        return sprintf('%s/%s/%s/%03d', $singkatan, $jenisAsetCode, $year, $sequenceNumber);
    }
    
    /**
     * Get the next sequence number for the given year and asset type
     */
    private static function getNextSequenceNumber($jenisAsetCode, $masjidSurauId, $year)
    {
        // Build pattern to search for
        $pattern = "%/{$jenisAsetCode}/{$year}/%";
        
        // Get the latest asset with this pattern using SQLite-compatible functions
        $latestAsset = Asset::where('masjid_surau_id', $masjidSurauId)
            ->where('no_siri_pendaftaran', 'LIKE', $pattern)
            ->orderBy(DB::raw("CAST(SUBSTR(no_siri_pendaftaran, LENGTH(no_siri_pendaftaran) - 2) AS INTEGER)"), 'DESC')
            ->first();

        if (!$latestAsset) {
            return 1;
        }

        // Extract sequence number from registration number using SQLite substr
        $registrationNumber = $latestAsset->no_siri_pendaftaran;
        $parts = explode('/', $registrationNumber);
        $lastSequence = (int)end($parts);
        
        return $lastSequence + 1;
    }
    
    /**
     * Validate asset registration number format
     */
    public static function validate($registrationNumber)
    {
        // Pattern: [Singkatan]/[Jenis]/[Tahun]/[Sequence]
        $pattern = '/^[A-Z]+\/[A-Z]+\/\d{2}\/\d{3}$/';
        return preg_match($pattern, $registrationNumber);
    }
    
    /**
     * Parse asset registration number into components
     */
    public static function parse($registrationNumber)
    {
        if (!self::validate($registrationNumber)) {
            return null;
        }

        $parts = explode('/', $registrationNumber);
        
        return [
            'singkatan_nama' => $parts[0],
            'jenis_aset_code' => $parts[1],
            'tahun' => $parts[2],
            'nombor_urutan' => $parts[3],
        ];
    }

    public static function getAssetTypeAbbreviations()
    {
        return self::$assetTypeAbbreviations;
    }
} 