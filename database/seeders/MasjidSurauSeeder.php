<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\MasjidSurau;
use DOMDocument;
use DOMXPath;

class MasjidSurauSeeder extends Seeder
{
    private $sources = [
        [
            'url' => 'https://e-masjid.jais.gov.my/dashboard/listmasjid',
            'type' => 'Masjid',
            'selector' => '//div[@class="card"]//table//tr[position()>1]',
            'columns' => [
                'name' => 1,
                'address' => 2,
                'district' => 3,
                'phone' => 4,
                'leader' => 5
            ]
        ],
        [
            'url' => 'https://e-masjid.jais.gov.my/dashboard/listsurau',
            'type' => 'Surau',
            'selector' => '//table[@class="table datatable"]//tr[position()>1]',
            'columns' => [
                'name_address' => 1,
                'phone_email' => 2,
                'kariah' => 3,
                'category' => 4
            ]
        ],
        [
            'url' => 'https://e-masjid.jais.gov.my/dashboard/listsuraujumaat',
            'type' => 'Surau',
            'selector' => '//table[@class="table datatable"]//tr[position()>1]',
            'columns' => [
                'name_address' => 1,
                'phone_email' => 2,
                'kariah' => 3,
                'category' => 4
            ]
        ]
    ];

    private $idCounter = 1;
    private $processedEntries = [];
    private $duplicatesFound = 0;

    private function generateDuplicateCheckKey($nama, $alamat, $daerah): string
    {
        // Clean and normalize the strings for comparison
        $cleanNama = Str::of($nama)
            ->lower()
            ->replaceMatches('/[^a-z0-9]/', '') // Remove all non-alphanumeric
            ->__toString();

        $cleanAlamat = Str::of($alamat)
            ->lower()
            ->replaceMatches('/[^a-z0-9]/', '') // Remove all non-alphanumeric
            ->__toString();

        $cleanDaerah = Str::of($daerah)
            ->lower()
            ->replaceMatches('/[^a-z0-9]/', '') // Remove all non-alphanumeric
            ->__toString();

        return "{$cleanNama}|{$cleanAlamat}|{$cleanDaerah}";
    }

    private function isDuplicate($nama, $alamat, $daerah): bool
    {
        $key = $this->generateDuplicateCheckKey($nama, $alamat, $daerah);
        if (isset($this->processedEntries[$key])) {
            $this->duplicatesFound++;
            return true;
        }
        $this->processedEntries[$key] = true;
        return false;
    }

    private function generateId(string $type, string $nama, string $daerah): string
    {
        // Clean and format the name
        $cleanName = Str::of($nama)
            ->replaceMatches('/^(Masjid|Surau)\s+/i', '') // Remove type prefix
            ->ascii() // Convert to ASCII
            ->replaceMatches('/[^a-zA-Z0-9]/', '') // Remove special characters
            ->upper(); // Convert to uppercase

        // Get first 3 letters of cleaned name, or pad if shorter
        $nameCode = Str::padRight(Str::substr($cleanName, 0, 3), 3, 'X');

        // Get first 2 letters of district, or pad if shorter
        $daerahCode = Str::padRight(Str::substr(Str::ascii($daerah), 0, 2), 2, 'X');

        // Generate sequential number
        $sequence = str_pad($this->idCounter++, 3, '0', STR_PAD_LEFT);

        // Combine all parts
        return sprintf(
            '%s-%s%s-%s',
            $type === 'Masjid' ? 'MSJ' : 'SRU',
            $nameCode,
            $daerahCode,
            $sequence
        );
    }

    private function parseSurauData($nameAddress, $phoneEmail, $kariah, $category)
    {
        // Decode HTML entities and normalize line breaks
        $nameAddress = html_entity_decode($nameAddress, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $nameAddress = str_replace(['<br>', '<br/>', '<br />'], "\n", $nameAddress);

        // Split into lines and clean up
        $lines = array_map('trim', explode("\n", $nameAddress));
        $lines = array_filter($lines, function ($line) {
            return !empty(trim($line));
        });
        $lines = array_values($lines);

        // First line is always the name
        $nama = $lines[0] ?? '';

        // Extract postal code from any line
        $poskod = '00000';
        foreach ($lines as $key => $line) {
            if (preg_match('/\b(\d{5})\b/', $line, $matches)) {
                $poskod = $matches[1];
                // Remove postal code from the line
                $lines[$key] = trim(str_replace($matches[0], '', $line));
                break;
            }
        }

        // Clean up name and get address parts
        $nameParts = explode(',', $nama);
        $nama = trim($nameParts[0]); // First part is always the name

        // Get address parts from remaining name parts and other lines
        $addressParts = array_merge(
            array_slice($nameParts, 1), // Address parts from name
            array_slice($lines, 1) // Address parts from other lines
        );

        // Clean up address parts
        $addressParts = array_map('trim', $addressParts);
        $addressParts = array_filter($addressParts);

        // Extract phone number and email
        $noTel = '';
        $email = '';
        $phoneEmail = html_entity_decode($phoneEmail, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (preg_match('/(\d[\d\-\s]+)/', $phoneEmail, $matches)) {
            $noTel = trim($matches[1]);
        }
        if (preg_match('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', $phoneEmail, $matches)) {
            $email = trim($matches[1]);
        }

        // Extract district from address - more flexible matching
        $daerah = '';
        $districtPatterns = [
            'Petaling' => [
                'Petaling',
                'Shah Alam',
                'Subang',
                'Puchong',
                'Seri Kembangan',
                'Damansara',
                'Kelana Jaya',
                'Seksyen U5',
                'Seksyen 13',
                'Seksyen 7',
                'USJ',
                'SS',
                'PJS',
                'Bandar Sunway',
                'Sungai Way',
                'Seksyen U',
                'Seksyen S',
                'Ara Damansara',
                'Glenmarie',
                'Saujana',
                'Bukit Jelutong'
            ],
            'Klang' => [
                'Klang',
                'Port Klang',
                'Kapar',
                'Meru',
                'Bukit Raja',
                'Bandar Bukit Tinggi',
                'Taman Berkeley',
                'Teluk Pulai',
                'Pandamaran',
                'Pelabuhan Klang',
                'Bandar Botanic'
            ],
            'Hulu Langat' => [
                'Hulu Langat',
                'Ampang',
                'Cheras',
                'Kajang',
                'Semenyih',
                'Bangi',
                'Balakong',
                'Sungai Long',
                'Taman Len Sen',
                'Taman Tasik Semenyih',
                'UKM',
                'Serdang'
            ],
            'Gombak' => [
                'Gombak',
                'Selayang',
                'Batu Caves',
                'Rawang',
                'Taman Melawati',
                'Wangsa Maju',
                'Taman Greenwood',
                'Taman Setapak',
                'Templer',
                'Kundang',
                'Selayang Heights'
            ],
            'Kuala Langat' => [
                'Kuala Langat',
                'Banting',
                'Telok Panglima Garang',
                'Jenjarom',
                'Morib',
                'Tanjung Sepat',
                'Sijangkang',
                'Jugra',
                'Telok Datok'
            ],
            'Kuala Selangor' => [
                'Kuala Selangor',
                'Tanjong Karang',
                'Bestari Jaya',
                'Ijok',
                'Jeram',
                'Pasangan',
                'Bukit Rotan',
                'Assam Jawa',
                'Puncak Alam'
            ],
            'Sabak Bernam' => [
                'Sabak Bernam',
                'Sungai Besar',
                'Sekinchan',
                'Sungai Air Tawar',
                'Parit Baru',
                'Bagan Nakhoda Omar',
                'Pasir Panjang'
            ],
            'Hulu Selangor' => [
                'Hulu Selangor',
                'Kuala Kubu Bharu',
                'Batang Kali',
                'Serendah',
                'Rasa',
                'Bukit Beruntung',
                'Kerling',
                'Kalumpang',
                'Tanjung Malim'
            ],
            'Sepang' => [
                'Sepang',
                'KLIA',
                'Cyberjaya',
                'Dengkil',
                'Salak Tinggi',
                'Sungai Pelek',
                'Taman Putra Perdana',
                'Kota Warisan',
                'Nilai'
            ]
        ];

        $fullAddress = implode(' ', array_merge([$nama], $addressParts));
        foreach ($districtPatterns as $district => $keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($fullAddress, $keyword) !== false) {
                    $daerah = $district;
                    break 2;
                }
            }
        }

        // If still no district found, try postal code
        if (empty($daerah) && $poskod !== '00000') {
            $poskodRanges = [
                ['40000', '40400', 'Shah Alam'],
                ['40450', '40680', 'Shah Alam'],
                ['40700', '40990', 'Shah Alam'],
                ['41000', '41200', 'Klang'],
                ['41300', '41400', 'Klang'],
                ['42000', '42800', 'Klang'],
                ['42900', '42940', 'Klang'],
                ['43000', '43009', 'Kajang'],
                ['43100', '43200', 'Cheras'],
                ['43300', '43400', 'Seri Kembangan'],
                ['43500', '43600', 'Semenyih'],
                ['43650', '43950', 'Bangi'],
                ['44000', '44300', 'Hulu Selangor'],
                ['45000', '45800', 'Kuala Selangor'],
                ['45100', '45700', 'Sabak Bernam'],
                ['46000', '46200', 'Petaling Jaya'],
                ['46300', '46530', 'Petaling Jaya'],
                ['46547', '46899', 'Petaling Jaya'],
                ['47000', '47199', 'Sungai Buloh'],
                ['47200', '47499', 'Subang Jaya'],
                ['47500', '47699', 'Subang Jaya'],
                ['47800', '47830', 'Petaling Jaya'],
                ['48000', '48300', 'Rawang'],
                ['68000', '68100', 'Batu Caves']
            ];

            foreach ($poskodRanges as $range) {
                if ($poskod >= $range[0] && $poskod <= $range[1]) {
                    $daerah = $this->getDistrictFromCity($range[2]);
                    break;
                }
            }
        }

        // Combine address parts into lines
        $alamatBaris1 = '';
        $alamatBaris2 = '';

        if (!empty($addressParts)) {
            // First non-empty part becomes address line 1
            $alamatBaris1 = reset($addressParts);

            // Remaining parts become address line 2
            $remainingParts = array_slice($addressParts, 1);
            if (!empty($remainingParts)) {
                $alamatBaris2 = implode(', ', $remainingParts);
            }
        }

        // If no address found, try to extract from name
        if (empty($alamatBaris1)) {
            // Look for common address indicators in the name
            $indicators = ['TAMAN', 'KAMPUNG', 'KG', 'JALAN', 'JLN', 'LORONG', 'LRG', 'PERSIARAN', 'PSRN', 'SEKSYEN', 'SEK'];
            foreach ($indicators as $indicator) {
                if (stripos($nama, $indicator) !== false) {
                    $parts = explode($indicator, $nama);
                    if (count($parts) > 1) {
                        $alamatBaris1 = $indicator . trim($parts[1]);
                        break;
                    }
                }
            }
        }

        // If still no district found, try to extract from kariah
        if (empty($daerah)) {
            $kariahAddress = implode(' ', [$kariah, $alamatBaris1, $alamatBaris2]);
            foreach ($districtPatterns as $district => $keywords) {
                foreach ($keywords as $keyword) {
                    if (stripos($kariahAddress, $keyword) !== false) {
                        $daerah = $district;
                        break 2;
                    }
                }
            }
        }

        return [
            'nama' => $nama,
            'alamat_baris_1' => $alamatBaris1,
            'alamat_baris_2' => $alamatBaris2,
            'poskod' => $poskod,
            'daerah' => $daerah,
            'no_tel' => $noTel,
            'email' => $email,
            'kariah' => trim($kariah),
            'kategori' => trim($category)
        ];
    }

    private function getDistrictFromCity($city)
    {
        $cityToDistrict = [
            'Shah Alam' => 'Petaling',
            'Klang' => 'Klang',
            'Kajang' => 'Hulu Langat',
            'Cheras' => 'Hulu Langat',
            'Seri Kembangan' => 'Hulu Langat',
            'Semenyih' => 'Hulu Langat',
            'Bangi' => 'Hulu Langat',
            'Hulu Selangor' => 'Hulu Selangor',
            'Kuala Selangor' => 'Kuala Selangor',
            'Sabak Bernam' => 'Sabak Bernam',
            'Petaling Jaya' => 'Petaling',
            'Sungai Buloh' => 'Petaling',
            'Subang Jaya' => 'Petaling',
            'Rawang' => 'Gombak',
            'Batu Caves' => 'Gombak'
        ];

        return $cityToDistrict[$city] ?? '';
    }

    public function run()
    {
        $this->command->info('Starting MasjidSurau seeder for Masjid Taman Melawati...');

        // Clear existing records first
        MasjidSurau::truncate();

        MasjidSurau::create([
            'nama' => 'Masjid Taman Melawati',
            'nama_rasmi' => 'Masjid Al-Hidayah Taman Melawati',
            'singkatan_nama' => 'MATM',
            'jenis' => 'Masjid',
            'kategori' => 'Kariah',
            'alamat_baris_1' => 'Jalan G1',
            'alamat_baris_2' => 'Taman Melawati',
            'poskod' => '53100',
            'bandar' => 'Kuala Lumpur',
            'negeri' => 'Wilayah Persekutuan Kuala Lumpur',
            'daerah' => 'Gombak',
            'negara' => 'Malaysia',
            'no_telefon' => '03-41075775',
            'status' => 'Aktif',
            'imam_ketua' => 'Ustaz Haji Ahmad bin Muhammad',
            'bilangan_jemaah' => 2000,
            'tahun_dibina' => 1985,
            'catatan' => 'Masjid utama bagi kariah Taman Melawati'
        ]);

        $this->command->info('Masjid Taman Melawati seeded successfully!');
    }
}
