<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LossWriteoffStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'kuantiti_kehilangan' => ['required', 'integer', 'min:1'],
            'tarikh_laporan' => ['required', 'date'],
            'tarikh_kehilangan' => ['nullable', 'date', 'before_or_equal:tarikh_laporan'],
            'jenis_kejadian' => ['required', 'string', Rule::in([
                'Kehilangan',
                'Hapus Kira',
            ])],
            'sebab_kejadian' => ['required', 'string', Rule::in([
                'Bencana Alam',
                'Kecurian',
                'Kecuaian',
                'Tidak Dapat Dikesan',
            ])],
            'butiran_kejadian' => ['required', 'string', 'max:2000'],
            'nilai_kehilangan' => ['required', 'numeric', 'min:0'],
            'laporan_polis' => ['nullable', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
            'dokumen_kehilangan' => ['nullable', 'array'],
            'dokumen_kehilangan.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Aset mesti dipilih.',
            'asset_id.exists' => 'Aset yang dipilih tidak sah.',
            'tarikh_laporan.required' => 'Tarikh laporan mesti diisi.',
            'tarikh_kehilangan.before_or_equal' => 'Tarikh kehilangan tidak boleh melebihi tarikh laporan.',
            'jenis_kejadian.required' => 'Jenis kejadian mesti dipilih.',
            'jenis_kejadian.in' => 'Jenis kejadian yang dipilih tidak sah.',
            'sebab_kejadian.required' => 'Sebab kejadian mesti dipilih.',
            'sebab_kejadian.in' => 'Sebab kejadian yang dipilih tidak sah.',
            'nilai_kehilangan.required' => 'Nilai kehilangan mesti diisi.',
            'nilai_kehilangan.min' => 'Nilai kehilangan mesti melebihi atau sama dengan 0.',
        ];
    }
}
