<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\AssetDataSheet;
use App\Exports\Sheets\AssetReferenceSheet;

class AssetExport implements WithMultipleSheets
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function sheets(): array
    {
        return [
            new AssetDataSheet($this->request),
            new AssetReferenceSheet(),
        ];
    }
}
