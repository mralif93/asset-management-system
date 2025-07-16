<?php

namespace Tests\Unit\Helpers;

use App\Helpers\AssetRegistrationNumber;
use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ReflectionClass;
use Carbon\Carbon;

class AssetRegistrationNumberTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testGenerateAssetRegistrationNumber()
    {
        // Create a test masjid/surau
        $masjid = MasjidSurau::factory()->create([
            'singkatan_nama' => 'MTAJ'
        ]);

        // Test with specific year
        $regNumber = AssetRegistrationNumber::generate($masjid->id, 'Harta Modal', '23');
        $this->assertEquals('MTAJ/HM/23/001', $regNumber);

        // Create an asset to test sequence increment
        Asset::factory()->create([
            'masjid_surau_id' => $masjid->id,
            'no_siri_pendaftaran' => 'MTAJ/HM/23/001',
            'jenis_aset' => 'Harta Modal'
        ]);

        // Generate another registration number, should increment
        $regNumber2 = AssetRegistrationNumber::generate($masjid->id, 'Harta Modal', '23');
        $this->assertEquals('MTAJ/HM/23/002', $regNumber2);
    }

    public function testGenerateWithDifferentAssetTypes()
    {
        // Create a test masjid/surau
        $masjid = MasjidSurau::factory()->create([
            'singkatan_nama' => 'MTAJ'
        ]);

        // Test different asset types
        $regNumber1 = AssetRegistrationNumber::generate($masjid->id, 'Inventori', '23');
        $this->assertEquals('MTAJ/I/23/001', $regNumber1);

        $regNumber2 = AssetRegistrationNumber::generate($masjid->id, 'Peralatan', '23');
        $this->assertEquals('MTAJ/P/23/001', $regNumber2);

        $regNumber3 = AssetRegistrationNumber::generate($masjid->id, 'Elektronik', '23');
        $this->assertEquals('MTAJ/E/23/001', $regNumber3);
    }

    public function testGenerateWithUnknownAssetType()
    {
        // Create a test masjid/surau
        $masjid = MasjidSurau::factory()->create([
            'singkatan_nama' => 'MTAJ'
        ]);

        // Test with unknown asset type (should use 'O' as default)
        $regNumber = AssetRegistrationNumber::generate($masjid->id, 'Unknown Type', '23');
        $this->assertEquals('MTAJ/O/23/001', $regNumber);
    }

    public function testGenerateImmovableAssetRegistrationNumber()
    {
        // Create a test masjid/surau
        $masjid = MasjidSurau::factory()->create([
            'singkatan_nama' => 'MTAJ'
        ]);

        // Test immovable asset registration number
        $regNumber = AssetRegistrationNumber::generateImmovable($masjid->id, '23');
        $this->assertEquals('MTAJ/HTA/23/001', $regNumber);
    }

    public function testValidateRegistrationNumber()
    {
        // Use reflection to test the validate method directly
        $reflectionMethod = new \ReflectionMethod(AssetRegistrationNumber::class, 'validate');
        
        // Make sure the pattern is '/^[A-Z]+\/[A-Z]+\/\d{2}\/\d{3}$/'
        $this->assertEquals(1, $reflectionMethod->invoke(null, 'MTAJ/HM/23/001'));
        $this->assertEquals(0, $reflectionMethod->invoke(null, 'MTAJ-HM-23-001')); // Wrong separators
        $this->assertEquals(0, $reflectionMethod->invoke(null, 'MTAJ/HM/23/01')); // Wrong sequence format
        $this->assertEquals(0, $reflectionMethod->invoke(null, 'mtaj/hm/23/001')); // Lowercase
        $this->assertEquals(0, $reflectionMethod->invoke(null, 'MTAJ/HM/2023/001')); // 4-digit year
        $this->assertEquals(0, $reflectionMethod->invoke(null, 'MTAJ/HM/23/1')); // Not 3 digits
    }

    public function testParseRegistrationNumber()
    {
        // Use the actual parse method, but we'll need to make sure validate returns true
        // for the test registration number
        
        // Set up a reflection method for validate
        $validateMethod = new \ReflectionMethod(AssetRegistrationNumber::class, 'validate');
        
        // Test with a valid registration number
        $this->assertEquals([
            'singkatan_nama' => 'MTAJ',
            'jenis_aset_code' => 'HM',
            'tahun' => '23',
            'nombor_urutan' => '001',
        ], AssetRegistrationNumber::parse('MTAJ/HM/23/001'));
        
        // Test with an invalid registration number
        $this->assertNull(AssetRegistrationNumber::parse('INVALID'));
    }

    public function testGetAssetTypeAbbreviations()
    {
        $abbreviations = AssetRegistrationNumber::getAssetTypeAbbreviations();
        $this->assertIsArray($abbreviations);
        $this->assertArrayHasKey('Harta Modal', $abbreviations);
        $this->assertEquals('HM', $abbreviations['Harta Modal']);
        $this->assertArrayHasKey('Inventori', $abbreviations);
        $this->assertEquals('I', $abbreviations['Inventori']);
    }

    public function testDefaultYearUsesCurrentYear()
    {
        // Create a test masjid/surau
        $masjid = MasjidSurau::factory()->create([
            'singkatan_nama' => 'MTAJ'
        ]);

        // Get current year's last two digits
        $currentYear = date('y');
        
        // Test with default year (should use current year)
        $regNumber = AssetRegistrationNumber::generate($masjid->id, 'Harta Modal');
        $this->assertEquals("MTAJ/HM/{$currentYear}/001", $regNumber);
    }
} 