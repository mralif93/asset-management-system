<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\MasjidSurau;

class MasjidSurauSeeder extends Seeder
{
    private $sources = [
        [
            'url' => 'https://e-masjid.jais.gov.my/dashboard/listmasjid',
            'type' => 'Masjid'
        ],
        [
            'url' => 'https://e-masjid.jais.gov.my/dashboard/listsurau',
            'type' => 'Surau'
        ],
        [
            'url' => 'https://e-masjid.jais.gov.my/dashboard/listsuraujumaat',
            'type' => 'Surau'
        ]
    ];

    public function run()
    {
        $this->command->info('Starting MasjidSurau data scraping from e-masjid.jais.gov.my...');

        // Check if Symfony DomCrawler is available
        if (!class_exists(Crawler::class)) {
            $this->command->warn('Symfony DomCrawler not found. Installing required package...');
            $this->command->info('Please run: composer require symfony/dom-crawler');
            
            // Fallback to manual data if scraping fails
            $this->createFallbackData();
            return;
        }

        $client = Http::withOptions([
            'verify' => false,
            'timeout' => 30,
            'connect_timeout' => 10
        ])->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language' => 'en-US,en;q=0.5',
            'Accept-Encoding' => 'gzip, deflate',
            'Connection' => 'keep-alive',
        ]);

        $totalProcessed = 0;

        foreach ($this->sources as $source) {
            $url = $source['url'];
            $type = $source['type'];
            
            $this->command->info("Processing {$type} from {$url}");

            try {
                // Initial request to get the page structure
                $initialResponse = $client->get($url);
                
                if ($initialResponse->failed()) {
                    $this->command->error("Failed to fetch initial page for {$url}. Status: " . $initialResponse->status());
                    continue;
                }

                $crawler = new Crawler($initialResponse->body());
                
                // Try to get CSRF token
                $csrfToken = null;
                try {
                    $csrfToken = $crawler->filter('meta[name="csrf-token"]')->attr('content');
                } catch (\Exception $e) {
                    $this->command->warn("Could not find CSRF token for {$url}");
                }
                
                // Try to get total records from DataTables info
                $totalRecords = 0;
                try {
                    $recordsText = $crawler->filter('.dataTables_info')->text();
                    preg_match('/(\d+)(?=\s+entries$)/', $recordsText, $matches);
                    $totalRecords = isset($matches[1]) ? (int)$matches[1] : 0;
                } catch (\Exception $e) {
                    $this->command->warn("Could not determine total records for {$url}");
                }

                if ($totalRecords > 0) {
                    $perPage = 10;
                    $totalPages = ceil($totalRecords / $perPage);
                    $this->command->info("Found {$totalRecords} records, processing {$totalPages} pages");

                    // Process pages
                    for ($page = 1; $page <= $totalPages; $page++) {
                        try {
                            $pageUrl = "{$url}?page={$page}";
                            $pageData = ['DataTables_Table_0_length' => $perPage];
                            
                            if ($csrfToken) {
                                $pageData['_token'] = $csrfToken;
                            }

                            $response = $client->asForm()->post($pageUrl, $pageData);

                            if ($response->successful()) {
                                $processed = $this->parsePage($response->body(), $type);
                                $totalProcessed += $processed;
                                $this->command->info("Processed page {$page}/{$totalPages} for {$type} - {$processed} records");
                            } else {
                                $this->command->error("Failed to fetch page {$page} for {$type}. Status: " . $response->status());
                            }
                        } catch (\Exception $e) {
                            $this->command->error("Error processing page {$page} for {$type}: " . $e->getMessage());
                        }
                        
                        // Rate limiting - be respectful to the server
                        sleep(2);
                    }
                } else {
                    // Try to parse the initial page directly
                    $processed = $this->parsePage($initialResponse->body(), $type);
                    $totalProcessed += $processed;
                    $this->command->info("Processed initial page for {$type} - {$processed} records");
                }

            } catch (\Exception $e) {
                $this->command->error("Error processing {$type} from {$url}: " . $e->getMessage());
                Log::error("MasjidSurauSeeder error for {$type}: " . $e->getMessage());
            }
        }

        if ($totalProcessed === 0) {
            $this->command->warn('No data was scraped. Creating fallback data...');
            $this->createFallbackData();
        } else {
            $this->command->info("Scraping completed! Total records processed: {$totalProcessed}");
        }
    }

    private function parsePage(string $html, string $type): int
    {
        $crawler = new Crawler($html);
        $processed = 0;
        
        try {
            $crawler->filter('tbody tr[role="row"]')->each(function (Crawler $row) use ($type, &$processed) {
                try {
                    $columns = $row->filter('td');
                    
                    if ($columns->count() < 5) {
                        return; // Skip rows with insufficient data
                    }

                    // Extract data from columns (adjust indices based on actual table structure)
                    $nama = trim($columns->eq(1)->text());
                    $namaRasmi = $columns->count() > 2 ? trim($columns->eq(2)->text()) : null;
                    $noTelefon = $columns->count() > 3 ? trim($columns->eq(3)->text()) : null;
                    $fullAddress = $columns->count() > 4 ? trim($columns->eq(4)->text()) : '';
                    $poskod = $columns->count() > 5 ? trim($columns->eq(5)->text()) : '00000';
                    $negeri = $columns->count() > 6 ? trim($columns->eq(6)->text()) : '';
                    $daerah = $columns->count() > 7 ? trim($columns->eq(7)->text()) : '';
                    $kawasan = $columns->count() > 8 ? trim($columns->eq(8)->text()) : null;
                    
                    // Extract map link if available
                    $pautanPeta = null;
                    if ($columns->count() > 9) {
                        try {
                            $mapLink = $columns->eq(9)->filter('a');
                            if ($mapLink->count() > 0) {
                                $pautanPeta = $mapLink->attr('href');
                            }
                        } catch (\Exception $e) {
                            // Map link extraction failed, continue without it
                        }
                    }

                    if (empty($nama)) {
                        return; // Skip if no name
                    }

                    // Split address into components
                    $addressLines = $this->splitAddress($fullAddress);
                    
                    // Generate singkatan_nama from nama
                    $singkatanNama = $this->generateSingkatan($nama);

                    // Check if record already exists
                    $exists = MasjidSurau::where('nama', $nama)
                                        ->where('jenis', $type)
                                        ->exists();
                    
                    if (!$exists) {
                        MasjidSurau::create([
                            'nama' => $nama,
                            'nama_rasmi' => $namaRasmi !== $nama ? $namaRasmi : null,
                            'singkatan_nama' => $singkatanNama,
                            'jenis' => $type,
                            'alamat_baris_1' => $addressLines[0] ?? null,
                            'alamat_baris_2' => $addressLines[1] ?? null,
                            'alamat_baris_3' => $addressLines[2] ?? null,
                            'poskod' => $poskod ?: '00000',
                            'negeri' => $negeri ?: 'Selangor',
                            'daerah' => $daerah,
                            'kawasan' => $kawasan,
                            'no_telefon' => $noTelefon,
                            'pautan_peta' => $pautanPeta,
                            'bandar' => $this->extractCity($fullAddress),
                            'negara' => 'Malaysia',
                            'status' => 'Aktif'
                        ]);
                        
                        $processed++;
                    }
                } catch (\Exception $e) {
                    Log::error("Error parsing row: " . $e->getMessage());
                }
            });
        } catch (\Exception $e) {
            Log::error("Error parsing page HTML: " . $e->getMessage());
        }

        return $processed;
    }

    private function splitAddress(string $address): array
    {
        if (empty($address)) {
            return [];
        }

        // Split address into logical components
        $parts = preg_split('/,\s*/', $address);
        $lines = [];
        
        if (count($parts) > 2) {
            // First line: Building/compound name
            $lines[] = $parts[0];
            // Second line: Street/area
            $lines[] = implode(', ', array_slice($parts, 1, -1));
            // Third line: City/postcode area
            $lines[] = end($parts);
        } elseif (count($parts) == 2) {
            $lines[] = $parts[0];
            $lines[] = $parts[1];
        } else {
            $lines[] = $address;
        }
        
        return array_slice($lines, 0, 3);
    }

    private function extractCity(string $address): string
    {
        if (empty($address)) {
            return '';
        }

        // Try to extract city name from address
        if (preg_match('/(\d{5})\s+(.*?)(?:,|$)/', $address, $matches)) {
            return trim($matches[2] ?? '');
        }
        
        // Fallback: take the last part before postcode
        $parts = preg_split('/,\s*/', $address);
        if (count($parts) > 1) {
            $lastPart = end($parts);
            // Remove postcode if present
            $cleaned = preg_replace('/\d{5}/', '', $lastPart);
            return trim($cleaned);
        }
        
        return '';
    }

    private function generateSingkatan(string $nama): string
    {
        // Remove common prefixes
        $cleaned = preg_replace('/^(Masjid|Surau)\s+/i', '', $nama);
        
        // Split into words and take first letter of each significant word
        $words = preg_split('/\s+/', $cleaned);
        $singkatan = '';
        
        foreach ($words as $word) {
            if (strlen($word) > 2 && !in_array(strtolower($word), ['dan', 'di', 'ke', 'dari', 'untuk'])) {
                $singkatan .= strtoupper(substr($word, 0, 1));
            }
        }
        
        // Ensure minimum length of 2 and maximum of 6
        if (strlen($singkatan) < 2) {
            $singkatan = strtoupper(substr($cleaned, 0, 3));
        }
        
        return substr($singkatan, 0, 6);
    }

    private function createFallbackData()
    {
        $this->command->info('Creating fallback sample data...');
        
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
                'status' => 'Aktif'
            ],
            [
                'nama' => 'Masjid Sultan Salahuddin Abdul Aziz',
                'nama_rasmi' => 'Masjid Sultan Salahuddin Abdul Aziz Shah',
                'singkatan_nama' => 'MSSAA',
                'jenis' => 'Masjid',
                'kategori' => 'Negeri',
                'alamat_baris_1' => 'Persiaran Masjid',
                'alamat_baris_2' => 'Seksyen 14',
                'poskod' => '40000',
                'bandar' => 'Shah Alam',
                'negeri' => 'Selangor',
                'daerah' => 'Petaling',
                'negara' => 'Malaysia',
                'no_telefon' => '03-55121951',
                'status' => 'Aktif'
            ],
            [
                'nama' => 'Surau Al-Hidayah',
                'singkatan_nama' => 'SAH',
                'jenis' => 'Surau',
                'kategori' => 'Kariah',
                'alamat_baris_1' => 'Taman Melawati',
                'poskod' => '53100',
                'bandar' => 'Kuala Lumpur',
                'negeri' => 'Kuala Lumpur',
                'daerah' => 'Gombak',
                'negara' => 'Malaysia',
                'status' => 'Aktif'
            ]
        ];

        foreach ($fallbackData as $data) {
            MasjidSurau::updateOrCreate(
                ['nama' => $data['nama'], 'jenis' => $data['jenis']],
                $data
            );
        }

        $this->command->info('Fallback data created successfully!');
    }
}
