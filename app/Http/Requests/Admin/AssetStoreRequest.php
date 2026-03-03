<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Helpers\AssetRegistrationNumber;

class AssetStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $assetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());

        return [
            'masjid_surau_id' => ['required', 'exists:masjid_surau,id'],
            'nama_aset' => ['required', 'string', 'max:255'],
            'kuantiti' => ['required', 'integer', 'min:1'],
            'jenis_aset' => ['required', 'string', Rule::in($assetTypes)],
            'kategori_aset' => ['required', 'string', Rule::in(['asset', 'non-asset'])],
            'tarikh_perolehan' => ['required', 'date', 'before_or_equal:today'],
            'kaedah_perolehan' => ['required', 'string', 'max:255'],
            'nilai_perolehan' => ['required', 'numeric', 'min:0'],
            'diskaun' => ['nullable', 'numeric', 'min:0'],
            'umur_faedah_tahunan' => ['nullable', 'integer', 'min:1', 'max:100'],
            'lokasi_penempatan' => ['required', 'string', 'max:255'],
            'pegawai_bertanggungjawab_lokasi' => ['required', 'string', 'max:255'],
            'jawatan_pegawai' => ['required', 'string', 'max:255'],
            'status_aset' => ['required', 'string', Rule::in([
                'Baru',
                'Aktif',
                'Sedang Digunakan',
                'Dalam Penyelenggaraan',
                'Rosak',
                'Dilupuskan',
                'Kehilangan',
            ])],
            'keadaan_fizikal' => ['required', 'string', Rule::in([
                'Baik',
                'Sederhana',
                'Rosak',
            ])],
            'status_jaminan' => ['nullable', 'string', Rule::in(['Aktif', 'Tamat', 'Tiada Jaminan'])],
            'tarikh_tamat_jaminan' => ['nullable', 'date', 'after:tarikh_perolehan'],
            'pembekal' => ['nullable', 'string', 'max:255'],
            'jenama' => ['nullable', 'string', 'max:255'],
            'gambar_aset' => ['nullable', 'array'],
            'gambar_aset.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'catatan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'masjid_surau_id.required' => 'Masjid/Surau mesti dipilih.',
            'masjid_surau_id.exists' => 'Masjid/Surau yang dipilih tidak sah.',
            'nama_aset.required' => 'Nama aset mesti diisi.',
            'jenis_aset.required' => 'Jenis aset mesti dipilih.',
            'jenis_aset.in' => 'Jenis aset yang dipilih tidak sah.',
            'kategori_aset.required' => 'Kategori aset mesti dipilih.',
            'kategori_aset.in' => 'Kategori aset mesti sama ada "asset" atau "non-asset".',
            'tarikh_perolehan.required' => 'Tarikh perolehan mesti diisi.',
            'tarikh_perolehan.before_or_equal' => 'Tarikh perolehan tidak boleh melebihi tarikh hari ini.',
            'nilai_perolehan.required' => 'Nilai perolehan mesti diisi.',
            'nilai_perolehan.min' => 'Nilai perolehan mesti melebihi atau sama dengan 0.',
            'status_aset.required' => 'Status aset mesti dipilih.',
            'status_aset.in' => 'Status aset yang dipilih tidak sah.',
            'keadaan_fizikal.required' => 'Keadaan fizikal mesti dipilih.',
            'keadaan_fizikal.in' => 'Keadaan fizikal mesti sama ada "Baik", "Sederhana", atau "Rosak".',
        ];
    }
}
