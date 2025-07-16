<?php

namespace Database\Factories;

use App\Models\MasjidSurau;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasjidSurau>
 */
class MasjidSurauFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MasjidSurau::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = $this->faker->randomElement(['Masjid', 'Surau']);
        $kategori = $jenis === 'Masjid' ? 
            $this->faker->randomElement(['Masjid Daerah', 'Masjid Kariah', 'Masjid Jamek']) :
            $this->faker->randomElement(['Surau Daerah', 'Surau Kariah']);
        
        return [
            'nama' => $jenis . ' ' . $this->faker->words(2, true),
            'singkatan_nama' => $this->faker->randomElement(['MTAJ', 'MSAJ', 'MKBJ', 'MSPJ']),
            'jenis' => $jenis,
            'kategori' => $kategori,
            'alamat_baris_1' => $this->faker->streetAddress(),
            'alamat_baris_2' => $this->faker->secondaryAddress(),
            'alamat_baris_3' => null,
            'poskod' => $this->faker->postcode(),
            'bandar' => $this->faker->city(),
            'negeri' => 'Selangor',
            'negara' => 'Malaysia',
            'daerah' => $this->faker->randomElement(['Petaling', 'Klang', 'Gombak', 'Hulu Langat', 'Kuala Selangor']),
            'no_telefon' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'imam_ketua' => $this->faker->name('male'),
            'bilangan_jemaah' => $this->faker->numberBetween(50, 1000),
            'tahun_dibina' => $this->faker->numberBetween(1950, 2023),
            'status' => 'Aktif',
            'catatan' => $this->faker->optional()->paragraph(),
            'nama_rasmi' => $jenis . ' ' . $this->faker->words(3, true),
            'kawasan' => $this->faker->randomElement(['Bandar', 'Luar Bandar', 'Pekan']),
            'pautan_peta' => $this->faker->url(),
        ];
    }
} 