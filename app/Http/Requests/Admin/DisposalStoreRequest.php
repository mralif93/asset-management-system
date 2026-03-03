<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisposalStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'kuantiti' => ['required', 'integer', 'min:1'],
            'tarikh_permohonan' => ['required', 'date'],
            'justifikasi_pelupusan' => ['required', 'string', 'max:1000'],
            'kaedah_pelupusan_dicadang' => ['required', 'string', Rule::in([
                'Dijual',
                'Dibuang',
                'Dikitar semula',
                'Disumbangkan',
                'Dipindahkan',
                'Lain-lain',
            ])],
            'kaedah_pelupusan' => ['nullable', 'string', Rule::in([
                'Dijual',
                'Dibuang',
                'Dikitar semula',
                'Disumbangkan',
                'Dipindahkan',
                'Lain-lain',
            ])],
            'nilai_pelupusan' => ['nullable', 'numeric', 'min:0'],
            'nilai_baki' => ['nullable', 'numeric', 'min:0'],
            'hasil_pelupusan' => ['nullable', 'numeric', 'min:0'],
            'tempat_pelupusan' => ['nullable', 'string', 'max:500'],
            'catatan' => ['nullable', 'string'],
            'gambar_pelupusan' => ['nullable', 'array'],
            'gambar_pelupusan.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Aset mesti dipilih.',
            'asset_id.exists' => 'Aset yang dipilih tidak sah.',
            'tarikh_permohonan.required' => 'Tarikh permohonan mesti diisi.',
            'justifikasi_pelupusan.required' => 'Justifikasi pelupusan mesti diisi.',
            'kaedah_pelupusan_dicadang.required' => 'Kaedah pelupusan dicadang mesti dipilih.',
            'kaedah_pelupusan_dicadang.in' => 'Kaedah pelupusan yang dipilih tidak sah.',
        ];
    }
}
