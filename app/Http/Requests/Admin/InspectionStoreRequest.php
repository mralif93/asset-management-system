<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InspectionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'tarikh_pemeriksaan' => ['required', 'date', 'before_or_equal:today'],
            'kondisi_aset' => ['required', 'string', Rule::in([
                'Baik',
                'Sederhana',
                'Rosak',
                'Sedang Digunakan',
                'Tidak Digunakan',
            ])],
            'lokasi_semasa_pemeriksaan' => ['required', 'string', 'max:255'],
            'cadangan_tindakan' => ['required', 'string', Rule::in([
                'Tiada Tindakan',
                'Penyelenggaraan',
                'Pelupusan',
                'Hapus Kira',
            ])],
            'pegawai_pemeriksa' => ['required', 'string', 'max:255'],
            'jawatan_pemeriksa' => ['required', 'string', 'max:255'],
            'catatan_pemeriksa' => ['nullable', 'string'],
            'tarikh_pemeriksaan_akan_datang' => ['nullable', 'date', 'after:tarikh_pemeriksaan'],
            'gambar_pemeriksaan' => ['nullable', 'array'],
            'gambar_pemeriksaan.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'signature' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Aset mesti dipilih.',
            'asset_id.exists' => 'Aset yang dipilih tidak sah.',
            'tarikh_pemeriksaan.required' => 'Tarikh pemeriksaan mesti diisi.',
            'tarikh_pemeriksaan.before_or_equal' => 'Tarikh pemeriksaan tidak boleh melebihi tarikh hari ini.',
            'kondisi_aset.required' => 'Kondisi aset mesti dipilih.',
            'kondisi_aset.in' => 'Kondisi aset yang dipilih tidak sah.',
            'cadangan_tindakan.required' => 'Cadangan tindakan mesti dipilih.',
            'pegawai_pemeriksa.required' => 'Nama pegawai pemeriksa mesti diisi.',
            'signature.required' => 'Tandatangan diperlukan.',
        ];
    }
}
