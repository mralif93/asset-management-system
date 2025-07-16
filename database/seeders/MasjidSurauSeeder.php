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
        return sprintf('%s-%s%s-%s', 
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
        $lines = array_filter($lines, function($line) {
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
                'Petaling', 'Shah Alam', 'Subang', 'Puchong', 'Seri Kembangan', 'Damansara', 'Kelana Jaya',
                'Seksyen U5', 'Seksyen 13', 'Seksyen 7', 'USJ', 'SS', 'PJS', 'Bandar Sunway', 'Sungai Way',
                'Seksyen U', 'Seksyen S', 'Ara Damansara', 'Glenmarie', 'Saujana', 'Bukit Jelutong'
            ],
            'Klang' => [
                'Klang', 'Port Klang', 'Kapar', 'Meru', 'Bukit Raja', 'Bandar Bukit Tinggi',
                'Taman Berkeley', 'Teluk Pulai', 'Pandamaran', 'Pelabuhan Klang', 'Bandar Botanic'
            ],
            'Hulu Langat' => [
                'Hulu Langat', 'Ampang', 'Cheras', 'Kajang', 'Semenyih', 'Bangi', 'Balakong',
                'Sungai Long', 'Taman Len Sen', 'Taman Tasik Semenyih', 'UKM', 'Serdang'
            ],
            'Gombak' => [
                'Gombak', 'Selayang', 'Batu Caves', 'Rawang', 'Taman Melawati', 'Wangsa Maju',
                'Taman Greenwood', 'Taman Setapak', 'Templer', 'Kundang', 'Selayang Heights'
            ],
            'Kuala Langat' => [
                'Kuala Langat', 'Banting', 'Telok Panglima Garang', 'Jenjarom', 'Morib',
                'Tanjung Sepat', 'Sijangkang', 'Jugra', 'Telok Datok'
            ],
            'Kuala Selangor' => [
                'Kuala Selangor', 'Tanjong Karang', 'Bestari Jaya', 'Ijok', 'Jeram',
                'Pasangan', 'Bukit Rotan', 'Assam Jawa', 'Puncak Alam'
            ],
            'Sabak Bernam' => [
                'Sabak Bernam', 'Sungai Besar', 'Sekinchan', 'Sungai Air Tawar',
                'Parit Baru', 'Bagan Nakhoda Omar', 'Pasir Panjang'
            ],
            'Hulu Selangor' => [
                'Hulu Selangor', 'Kuala Kubu Bharu', 'Batang Kali', 'Serendah', 'Rasa',
                'Bukit Beruntung', 'Kerling', 'Kalumpang', 'Tanjung Malim'
            ],
            'Sepang' => [
                'Sepang', 'KLIA', 'Cyberjaya', 'Dengkil', 'Salak Tinggi',
                'Sungai Pelek', 'Taman Putra Perdana', 'Kota Warisan', 'Nilai'
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
        $this->command->info('Starting MasjidSurau seeder...');

        try {
            // Clear existing records first
            MasjidSurau::truncate();
            $this->command->info('Cleared existing records');
            
            // Reset counters
            $this->processedEntries = [];
            $this->duplicatesFound = 0;
            $totalCreated = 0;
            $masjidCount = 0;
            $surauCount = 0;
            
            foreach ($this->sources as $source) {
                $this->command->info("Fetching data from: {$source['url']}");
                
                $response = Http::withoutVerifying()
                    ->timeout(30)
                    ->get($source['url']);

                if ($response->successful()) {
                    $html = $response->body();
                    
                    // Create a new DOM document
                    $dom = new DOMDocument();
                    @$dom->loadHTML($html, LIBXML_NOERROR); // @ to suppress warnings about malformed HTML
                    
                    // Create XPath object
                    $xpath = new DOMXPath($dom);
                    
                    // Find all table rows using the source-specific selector
                    $rows = $xpath->query($source['selector']);
                    
                    if ($rows && $rows->length > 0) {
                        foreach ($rows as $row) {
                            $columns = $xpath->query('.//td', $row);
                            
                            if ($columns->length >= count($source['columns'])) {
                                if ($source['type'] === 'Masjid') {
                                    $nama = trim($columns->item($source['columns']['name'])->textContent);
                                    $alamat = trim($columns->item($source['columns']['address'])->textContent);
                                    $daerah = trim($columns->item($source['columns']['district'])->textContent);
                                    $noTel = trim($columns->item($source['columns']['phone'])->textContent);
                                    $imamKetua = trim($columns->item($source['columns']['leader'])->textContent);
                                    
                                    // Skip if name is empty
                                    if (empty($nama)) {
                                        continue;
                                    }
                                    
                                    // Check for duplicates
                                    if ($this->isDuplicate($nama, $alamat, $daerah)) {
                                        continue;
                                    }
                                    
                                    // Parse address into components
                                    $alamatParts = explode(',', $alamat);
                                    $poskod = preg_match('/\b\d{5}\b/', $alamat, $matches) ? $matches[0] : '00000';
                                    
                                    $record = [
                                        'nama' => $nama,
                                        'nama_rasmi' => $nama,
                                        'singkatan_nama' => Str::upper(substr(preg_replace('/[^A-Za-z0-9]/', '', $nama), 0, 5)),
                                        'jenis' => $source['type'],
                                        'kategori' => 'Kariah',
                                        'alamat_baris_1' => trim($alamatParts[0] ?? ''),
                                        'alamat_baris_2' => trim($alamatParts[1] ?? ''),
                                        'poskod' => $poskod,
                                        'bandar' => trim($alamatParts[count($alamatParts)-2] ?? ''),
                                        'negeri' => 'Selangor',
                                        'daerah' => trim($daerah),
                                        'negara' => 'Malaysia',
                                        'no_telefon' => $noTel,
                                        'status' => 'Aktif',
                                        'imam_ketua' => $imamKetua,
                                        'bilangan_jemaah' => rand(100, 1000),
                                        'tahun_dibina' => rand(1950, 2020),
                                        'catatan' => "Data diperolehi dari e-masjid JAIS"
                                    ];
                                } else {
                                    // Parse Surau data
                                    $data = $this->parseSurauData(
                                        $columns->item($source['columns']['name_address'])->textContent,
                                        $columns->item($source['columns']['phone_email'])->textContent,
                                        $columns->item($source['columns']['kariah'])->textContent,
                                        $columns->item($source['columns']['category'])->textContent
                                    );
                                    
                                    // Skip if name is empty
                                    if (empty($data['nama'])) {
                                        continue;
                                    }
                                    
                                    // Check for duplicates
                                    if ($this->isDuplicate($data['nama'], $data['alamat_baris_1'], $data['daerah'])) {
                                        continue;
                                    }
                                    
                                    $record = [
                                        'nama' => $data['nama'],
                                        'nama_rasmi' => $data['nama'],
                                        'singkatan_nama' => Str::upper(substr(preg_replace('/[^A-Za-z0-9]/', '', $data['nama']), 0, 5)),
                                        'jenis' => $source['type'],
                                        'kategori' => $data['kategori'],
                                        'alamat_baris_1' => $data['alamat_baris_1'],
                                        'alamat_baris_2' => $data['alamat_baris_2'],
                                        'poskod' => $data['poskod'],
                                        'bandar' => trim($data['alamat_baris_2'] ?? ''),
                                        'negeri' => 'Selangor',
                                        'daerah' => $data['daerah'],
                                        'negara' => 'Malaysia',
                                        'no_telefon' => $data['no_tel'],
                                        'email' => $data['email'],
                                        'status' => 'Aktif',
                                        'imam_ketua' => '',
                                        'bilangan_jemaah' => rand(50, 500), // Smaller range for Surau
                                        'tahun_dibina' => rand(1950, 2020),
                                        'catatan' => "Data diperolehi dari e-masjid JAIS. Kariah: {$data['kariah']}"
                                    ];
                                }
                                
                                MasjidSurau::create($record);
                                $totalCreated++;
                                
                                if ($source['type'] === 'Masjid') {
                                    $masjidCount++;
                                } else {
                                    $surauCount++;
                                }
                            }
                        }
                        
                        $this->command->info("Successfully processed {$source['type']} data");
                    } else {
                        $this->command->warn("No data found in {$source['url']} using selector: {$source['selector']}");
                    }
                } else {
                    $this->command->error("Failed to fetch data from {$source['url']}. Status: " . $response->status());
                    Log::error("Failed to fetch data from {$source['url']}", [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                }
            }
            
            if ($totalCreated === 0) {
                $this->command->warn('No records were created from online sources. Falling back to sample data...');
                $this->createFallbackData();
            } else {
                $this->command->info("Total records created: $totalCreated");
                $this->command->info("Masjid count: $masjidCount");
                $this->command->info("Surau count: $surauCount");
                $this->command->info("Duplicates skipped: {$this->duplicatesFound}");
            }
            
        } catch (\Exception $e) {
            $this->command->error('Error occurred while fetching data: ' . $e->getMessage());
            Log::error('Error in MasjidSurauSeeder', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->command->warn('Falling back to sample data...');
            $this->createFallbackData();
        }
    }

    private function createFallbackData()
    {
        $fallbackData = [
            [
                'nama' => 'Masjid Negara',
                'nama_rasmi' => 'Masjid Negara Malaysia',
                'singkatan_nama' => 'MN',
                'jenis' => 'Masjid',
                'kategori' => 'Persekutuan',
                'alamat_baris_1' => 'Jalan Perdana',
                'alamat_baris_2' => 'Tasik Perdana',
                'poskod' => '50480',
                'bandar' => 'Kuala Lumpur',
                'negeri' => 'Kuala Lumpur',
                'daerah' => 'Kuala Lumpur',
                'negara' => 'Malaysia',
                'no_telefon' => '03-26910733',
                'status' => 'Aktif',
                'imam_ketua' => 'Ustaz Dr. Ahmad bin Abdullah',
                'bilangan_jemaah' => 15000,
                'tahun_dibina' => 1965,
                'pautan_peta' => 'https://goo.gl/maps/masjidnegara',
                'catatan' => 'Masjid Negara Malaysia merupakan masjid utama negara.'
            ],
            [
                'nama' => 'Masjid Jamek',
                'nama_rasmi' => 'Masjid Jamek Sultan Abdul Samad',
                'singkatan_nama' => 'MJSAS',
                'jenis' => 'Masjid',
                'kategori' => 'Persekutuan',
                'alamat_baris_1' => 'Jalan Tun Perak',
                'poskod' => '50050',
                'bandar' => 'Kuala Lumpur',
                'negeri' => 'Kuala Lumpur',
                'daerah' => 'Kuala Lumpur',
                'negara' => 'Malaysia',
                'no_telefon' => '03-20310360',
                'status' => 'Aktif',
                'imam_ketua' => 'Ustaz Abdul Rahman bin Abdullah',
                'bilangan_jemaah' => 5000,
                'tahun_dibina' => 1909,
                'pautan_peta' => 'https://goo.gl/maps/masjidjamek',
                'catatan' => 'Masjid bersejarah yang terletak di pertemuan Sungai Klang dan Sungai Gombak.'
            ],
            [
                'nama' => 'Masjid Sultan Salahuddin Abdul Aziz Shah',
                'nama_rasmi' => 'Masjid Sultan Salahuddin Abdul Aziz Shah',
                'singkatan_nama' => 'MSSAAS',
                'jenis' => 'Masjid',
                'kategori' => 'Negeri',
                'alamat_baris_1' => 'Persiaran Masjid',
                'alamat_baris_2' => 'Seksyen 14',
                'poskod' => '40000',
                'bandar' => 'Shah Alam',
                'negeri' => 'Selangor',
                'daerah' => 'Petaling',
                'negara' => 'Malaysia',
                'no_telefon' => '03-55159988',
                'status' => 'Aktif',
                'imam_ketua' => 'Ustaz Mohammad bin Ibrahim',
                'bilangan_jemaah' => 24000,
                'tahun_dibina' => 1988,
                'pautan_peta' => 'https://goo.gl/maps/masjidshahalam',
                'catatan' => 'Masjid Sultan Salahuddin Abdul Aziz Shah atau Masjid Biru merupakan masjid utama negeri Selangor.'
            ],
            [
                'nama' => 'Masjid Putra',
                'nama_rasmi' => 'Masjid Putra Putrajaya',
                'singkatan_nama' => 'MPP',
                'jenis' => 'Masjid',
                'kategori' => 'Persekutuan',
                'alamat_baris_1' => 'Persiaran Persekutuan',
                'alamat_baris_2' => 'Presint 1',
                'poskod' => '62502',
                'bandar' => 'Putrajaya',
                'negeri' => 'Wilayah Persekutuan Putrajaya',
                'daerah' => 'Putrajaya',
                'negara' => 'Malaysia',
                'no_telefon' => '03-88885000',
                'status' => 'Aktif',
                'imam_ketua' => 'Ustaz Hasanuddin bin Mohd Yunus',
                'bilangan_jemaah' => 15000,
                'tahun_dibina' => 1999,
                'pautan_peta' => 'https://goo.gl/maps/masjidputra',
                'catatan' => 'Masjid Putra merupakan mercu tanda Putrajaya yang terkenal dengan warna merah jambu.'
            ],
            [
                'nama' => 'Surau Ar-Rahman',
                'singkatan_nama' => 'SAR',
                'jenis' => 'Surau',
                'kategori' => 'Kariah',
                'alamat_baris_1' => 'Jalan SS 7/2',
                'alamat_baris_2' => 'Kelana Jaya',
                'poskod' => '47301',
                'bandar' => 'Petaling Jaya',
                'negeri' => 'Selangor',
                'daerah' => 'Petaling',
                'negara' => 'Malaysia',
                'no_telefon' => '03-78854321',
                'status' => 'Aktif',
                'imam_ketua' => 'Ustaz Zulkifli bin Ahmad',
                'bilangan_jemaah' => 150,
                'tahun_dibina' => 2015,
                'pautan_peta' => 'https://goo.gl/maps/suraurahman',
                'catatan' => 'Surau komuniti untuk penduduk Kelana Jaya.'
            ],
            [
                'nama' => 'Surau Al-Ikhlas',
                'singkatan_nama' => 'SAI',
                'jenis' => 'Surau',
                'kategori' => 'Kariah',
                'alamat_baris_1' => 'Jalan Damansara',
                'alamat_baris_2' => 'Damansara Heights',
                'poskod' => '50490',
                'bandar' => 'Kuala Lumpur',
                'negeri' => 'Kuala Lumpur',
                'daerah' => 'Kuala Lumpur',
                'negara' => 'Malaysia',
                'no_telefon' => '03-20923456',
                'status' => 'Aktif',
                'imam_ketua' => 'Ustaz Kamal bin Hassan',
                'bilangan_jemaah' => 200,
                'tahun_dibina' => 2010,
                'pautan_peta' => 'https://goo.gl/maps/suraualikhas',
                'catatan' => 'Surau untuk komuniti Damansara Heights.'
            ],
            [
                'nama' => 'Surau An-Nur',
                'singkatan_nama' => 'SAN',
                'jenis' => 'Surau',
                'kategori' => 'Kariah',
                'alamat_baris_1' => 'Jalan PJU 10/1',
                'alamat_baris_2' => 'Damansara Damai',
                'poskod' => '47830',
                'bandar' => 'Petaling Jaya',
                'negeri' => 'Selangor',
                'daerah' => 'Petaling',
                'negara' => 'Malaysia',
                'no_telefon' => '03-61567890',
                'status' => 'Aktif',
                'imam_ketua' => 'Ustaz Razali bin Mahmud',
                'bilangan_jemaah' => 180,
                'tahun_dibina' => 2012,
                'pautan_peta' => 'https://goo.gl/maps/surauannur',
                'catatan' => 'Surau untuk komuniti Damansara Damai.'
            ],
            [
                'nama' => 'Masjid Wilayah Persekutuan',
                'nama_rasmi' => 'Masjid Wilayah Persekutuan Kuala Lumpur',
                'singkatan_nama' => 'MWP',
                'jenis' => 'Masjid',
                'kategori' => 'Persekutuan',
                'alamat_baris_1' => 'Jalan Tuanku Abdul Halim',
                'alamat_baris_2' => 'Kompleks Kerajaan',
                'poskod' => '50480',
                'bandar' => 'Kuala Lumpur',
                'negeri' => 'Kuala Lumpur',
                'daerah' => 'Kuala Lumpur',
                'negara' => 'Malaysia',
                'no_telefon' => '03-62015674',
                'status' => 'Aktif',
                'imam_ketua' => 'Ustaz Dr. Mohd Daud bin Bakar',
                'bilangan_jemaah' => 17000,
                'tahun_dibina' => 2000,
                'pautan_peta' => 'https://goo.gl/maps/masjidwilayah',
                'catatan' => 'Masjid Wilayah Persekutuan merupakan salah satu masjid terbesar di Asia Tenggara.'
            ]
        ];

        foreach ($fallbackData as $data) {
            MasjidSurau::create($data);
        }

        $this->command->info('Sample data created successfully!');
    }
}
