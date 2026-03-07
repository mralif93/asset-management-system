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
                'name' => 2,
                'address' => 0, // No address in the list
                'district' => 3,
                'category' => 4,
                'phone' => 5,
                'leader' => 0 // No leader in the list
            ]
        ],
        [
            'url' => 'https://e-masjid.jais.gov.my/dashboard/listsurau',
            'type' => 'Surau',
            'selector' => '//table[contains(@class, "datatable")]//tr[position()>1]',
            'columns' => [
                'name_address' => 2,
                'phone_email' => 3,
                'kariah' => 4,
                'category' => 5
            ]
        ],
        [
            'url' => 'https://e-masjid.jais.gov.my/dashboard/listsuraujumaat',
            'type' => 'Surau',
            'selector' => '//table[contains(@class, "datatable")]//tr[position()>1]',
            'columns' => [
                'name_address' => 2,
                'phone_email' => 3,
                'kariah' => 4,
                'category' => 5
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
        $this->command->info('Starting MasjidSurau seeder by fetching data from URLs...');

        // Clear existing records first
        MasjidSurau::truncate();

        foreach ($this->sources as $source) {
            $this->command->info("Fetching data from: {$source['url']}");

            try {
                $response = Http::withoutVerifying()->get($source['url']);

                if (!$response->successful()) {
                    $this->command->error("Failed to fetch data from {$source['url']}. Status: " . $response->status());
                    continue;
                }

                $html = $response->body();

                // Suppress libxml warnings for malformed HTML
                libxml_use_internal_errors(true);

                $dom = new DOMDocument();
                // Avoid mb_convert_encoding on large HTML to fix silent failures
                @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $xpath = new DOMXPath($dom);
                $rows = $xpath->query($source['selector']);

                if (!$rows || $rows->length === 0) {
                    $this->command->warn("No data found for {$source['type']} at {$source['url']}");
                    continue;
                }

                $count = 0;

                foreach ($rows as $row) {
                    $cells = $xpath->query('.//td', $row);

                    if ($cells->length < count($source['columns'])) {
                        continue;
                    }

                    try {
                        if ($source['type'] === 'Masjid') {
                            $name = trim($cells->item($source['columns']['name'] - 1)->nodeValue ?? '');
                            $district = trim($cells->item($source['columns']['district'] - 1)->nodeValue ?? '');
                            $category = trim($cells->item($source['columns']['category'] - 1)->nodeValue ?? '');

                            if (empty($name) || $this->isDuplicate($name, '', $district)) {
                                continue;
                            }

                            $phone = trim($cells->item($source['columns']['phone'] - 1)->nodeValue ?? '');

                            // Initialize extra fields
                            $capacity = null;
                            $yearBuilt = null;
                            $notes = '';
                            $leader = '';

                            // Skipping profile fetching for now to speed up the seeder
                            // (Previously fetched Kapasiti, Tarikh Dibina, etc.)

                            MasjidSurau::create([
                                'nama' => $name,
                                'nama_rasmi' => $name,
                                'jenis' => 'Masjid',
                                'kategori' => $category,
                                'daerah' => $district,
                                'no_telefon' => $phone,
                                'imam_ketua' => $leader,
                                'bilangan_jemaah' => $capacity,
                                'tahun_dibina' => $yearBuilt,
                                'catatan' => trim($notes),
                                'status' => 'Aktif',
                            ]);
                            $count++;
                        } else {
                            $nameAddressCell = $cells->item($source['columns']['name_address'] - 1);
                            $innerHtml = '';
                            if ($nameAddressCell) {
                                foreach ($nameAddressCell->childNodes as $child) {
                                    $innerHtml .= $dom->saveHTML($child);
                                }
                            }

                            $phoneEmailCell = $cells->item($source['columns']['phone_email'] - 1);
                            $phoneEmailInner = '';
                            if ($phoneEmailCell) {
                                foreach ($phoneEmailCell->childNodes as $child) {
                                    $phoneEmailInner .= $dom->saveHTML($child);
                                }
                            }

                            $kariah = trim($cells->item($source['columns']['kariah'] - 1)->nodeValue ?? '');
                            $category = trim($cells->item($source['columns']['category'] - 1)->nodeValue ?? '');

                            $parsed = $this->parseSurauData($innerHtml, $phoneEmailInner, $kariah, $category);

                            if (empty($parsed['nama']) || $this->isDuplicate($parsed['nama'], trim($parsed['alamat_baris_1'] . ' ' . $parsed['alamat_baris_2']), $parsed['daerah'])) {
                                continue;
                            }

                            MasjidSurau::create([
                                'nama' => $parsed['nama'],
                                'nama_rasmi' => $parsed['nama'],
                                'jenis' => 'Surau',
                                'kategori' => $parsed['kategori'],
                                'alamat_baris_1' => $parsed['alamat_baris_1'],
                                'alamat_baris_2' => $parsed['alamat_baris_2'],
                                'poskod' => $parsed['poskod'],
                                'daerah' => $parsed['daerah'],
                                'no_telefon' => $parsed['no_tel'],
                                'email' => $parsed['email'],
                                'catatan' => 'Kariah: ' . $parsed['kariah'],
                                'status' => 'Aktif',
                            ]);
                            $count++;
                        }
                    } catch (\Exception $e) {
                        Log::error("Error processing row: " . $e->getMessage());
                    }
                }

                $this->command->info("Seeded $count items for {$source['type']} from {$source['url']}");
                libxml_clear_errors();

            } catch (\Exception $e) {
                $this->command->error("Exception while fetching {$source['url']}: " . $e->getMessage());
            }
        }

        $this->command->info("Total duplicates skipped: {$this->duplicatesFound}");
        $this->command->info('MasjidSurau seeding completed!');

        // --- PREVIOUS SAMPLE DATA (Kept for reference, not executed) ---
        /*
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

        MasjidSurau::create([
            'nama' => 'Surau Al-Ikhlas',
            'nama_rasmi' => 'Surau Al-Ikhlas Taman Melawati',
            'singkatan_nama' => 'SAITM',
            'jenis' => 'Surau',
            'kategori' => 'Kariah',
            'alamat_baris_1' => 'Jalan J',
            'alamat_baris_2' => 'Taman Melawati',
            'poskod' => '53100',
            'bandar' => 'Kuala Lumpur',
            'negeri' => 'Wilayah Persekutuan Kuala Lumpur',
            'daerah' => 'Gombak',
            'negara' => 'Malaysia',
            'no_telefon' => '03-41071234',
            'status' => 'Aktif',
            'imam_ketua' => 'Ustaz Ali Bin Abu',
            'bilangan_jemaah' => 500,
            'tahun_dibina' => 1995,
            'catatan' => 'Surau utama bagi Fasa 3 Taman Melawati'
        ]);

        MasjidSurau::create([
            'nama' => 'Masjid Melawati',
            'nama_rasmi' => 'Masjid Melawati',
            'singkatan_nama' => 'MSJM',
            'jenis' => 'Masjid',
            'kategori' => 'Kariah',
            'alamat_baris_1' => 'Jalan Melawati 5',
            'alamat_baris_2' => '53100, Kuala Lumpur',
            'poskod' => '53100',
            'bandar' => 'Kuala Lumpur',
            'negeri' => 'Wilayah Persekutuan Kuala Lumpur',
            'daerah' => 'Gombak',
            'negara' => 'Malaysia',
            'no_telefon' => '03-90000000',
            'status' => 'Aktif',
            'imam_ketua' => 'TBD Imam Melawati',
            'bilangan_jemaah' => 1500,
            'tahun_dibina' => 2005,
            'catatan' => 'Masjid baru untuk kariah Melawati'
        ]);
        */
    }
}
