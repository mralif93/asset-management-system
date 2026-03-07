<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Inspection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inspection>
 */
class InspectionFactory extends Factory
{
    protected $model = Inspection::class;

    public function definition(): array
    {
        return [
            'asset_id' => Asset::factory(),
            'user_id' => User::factory(),
            'tarikh_pemeriksaan' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'kondisi_aset' => $this->faker->randomElement(['Baik', 'Sederhana', 'Rosak']),
            'lokasi_semasa_pemeriksaan' => 'Stor Utama',
            'cadangan_tindakan' => $this->faker->randomElement(['Tiada', 'Penyelenggaraan']),
            'pegawai_pemeriksa' => $this->faker->name(),
            'jawatan_pemeriksa' => 'Pegawai Aset',
            'catatan_pemeriksa' => $this->faker->optional()->sentence(),
            'signature' => $this->faker->optional()->passthrough(base64_encode($this->faker->sha256())),
            'tarikh_pemeriksaan_akan_datang' => $this->faker->optional()->date(),
        ];
    }
}
