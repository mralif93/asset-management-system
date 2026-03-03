<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaintenanceRecordStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'tarikh_penyelenggaraan' => ['required', 'date'],
            'jenis_penyelenggaraan' => ['required', 'string', Rule::in([
                'Pencegahan',
                'Betulan',
                'Pembaikan',
                'Tukar Ganti',
                'Pemeriksaan',
            ])],
            'butiran_kerja' => ['required', 'string', 'max:2000'],
            'penyedia_perkhidmatan' => ['required', 'string', 'max:255'],
            'kos_penyelenggaraan' => ['required', 'numeric', 'min:0'],
            'status_penyelenggaraan' => ['required', 'string', Rule::in([
                'Selesai',
                'Dalam Proses',
                'Dijadualkan',
                'Dibatalkan',
            ])],
            'pegawai_bertanggungjawab' => ['required', 'string', 'max:255'],
            'tarikh_penyelenggaraan_akan_datang' => ['nullable', 'date', 'after:tarikh_penyelenggaraan'],
            'catatan_penyelenggaraan' => ['nullable', 'string'],
            'gambar_penyelenggaraan' => ['nullable', 'array'],
            'gambar_penyelenggaraan.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Aset mesti dipilih.',
            'asset_id.exists' => 'Aset yang dipilih tidak sah.',
            'tarikh_penyelenggaraan.required' => 'Tarikh penyelenggaraan mesti diisi.',
            'jenis_penyelenggaraan.required' => 'Jenis penyelenggaraan mesti dipilih.',
            'jenis_penyelenggaraan.in' => 'Jenis penyelenggaraan yang dipilih tidak sah.',
            'kos_penyelenggaraan.required' => 'Kos penyelenggaraan mesti diisi.',
            'kos_penyelenggaraan.min' => 'Kos penyelenggaraan mesti melebihi atau sama dengan 0.',
            'status_penyelenggaraan.required' => 'Status penyelenggaraan mesti dipilih.',
            'status_penyelenggaraan.in' => 'Status penyelenggaraan yang dipilih tidak sah.',
        ];
    }
}
