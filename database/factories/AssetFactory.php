<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisAset = $this->faker->randomElement([
            'Harta Modal', 'Inventori', 'Peralatan', 'Kenderaan', 
            'Perabot', 'Elektronik', 'Buku', 'Pakaian'
        ]);
        
        $statusAset = $this->faker->randomElement([
            'Sedang Digunakan', 'Dalam Baik Pulih', 'Rosak', 'Lupus'
        ]);
        
        return [
            'id' => $this->faker->unique()->randomNumber(5),
            'masjid_surau_id' => MasjidSurau::factory(),
            'no_siri_pendaftaran' => $this->faker->unique()->regexify('[A-Z]{4}/[A-Z]{1,3}/\d{2}/\d{3}'),
            'nama_aset' => $this->faker->words(3, true),
            'jenis_aset' => $jenisAset,
            'tarikh_perolehan' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'kaedah_perolehan' => $this->faker->randomElement(['Pembelian', 'Sumbangan', 'Wakaf']),
            'nilai_perolehan' => $this->faker->randomFloat(2, 100, 10000),
            'umur_faedah_tahunan' => $this->faker->optional()->numberBetween(1, 10),
            'susut_nilai_tahunan' => $this->faker->optional()->randomFloat(2, 10, 1000),
            'lokasi_penempatan' => $this->faker->randomElement(['Dewan Solat', 'Pejabat', 'Dapur', 'Bilik Mesyuarat']),
            'pegawai_bertanggungjawab_lokasi' => $this->faker->name(),
            'status_aset' => $statusAset,
            'gambar_aset' => json_encode([$this->faker->imageUrl()]),
            'no_resit' => $this->faker->optional()->bothify('R-####-??'),
            'tarikh_resit' => $this->faker->optional()->dateTimeBetween('-5 years', 'now'),
            'dokumen_resit_url' => $this->faker->optional()->url(),
            'pembekal' => $this->faker->optional()->company(),
            'jenama' => $this->faker->optional()->word(),
            'no_pesanan_kerajaan' => $this->faker->optional()->bothify('PK-####-??'),
            'no_rujukan_kontrak' => $this->faker->optional()->bothify('RK-####-??'),
            'tempoh_jaminan' => $this->faker->optional()->numberBetween(1, 36) . ' bulan',
            'tarikh_tamat_jaminan' => $this->faker->optional()->dateTimeBetween('now', '+3 years'),
            'catatan' => $this->faker->optional()->sentence(),
        ];
    }
} 