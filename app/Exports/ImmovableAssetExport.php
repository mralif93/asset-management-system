<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\ImmovableAssetDataSheet;
use App\Exports\Sheets\ImmovableAssetReferenceSheet;

class ImmovableAssetExport implements WithMultipleSheets
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function sheets(): array
    {
        return [
            new ImmovableAssetDataSheet($this->request),
            new ImmovableAssetReferenceSheet(),
        ];
    }
}
