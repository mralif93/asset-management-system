<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disposal>
 */
class DisposalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status_pelupusan' => 'Dimohon',
            'tarikh_permohonan' => now(),
            'justifikasi_pelupusan' => 'Rosak Teruk',
            'kaedah_pelupusan_dicadang' => 'Jualan',
            'pegawai_pemohon' => 'Pekerja Ujian',
        ];
    }
}
