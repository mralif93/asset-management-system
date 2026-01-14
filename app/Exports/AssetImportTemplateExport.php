<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\AssetTemplateSheet;
use App\Exports\Sheets\AssetReferenceSheet;

class AssetImportTemplateExport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new AssetTemplateSheet();
        $sheets[] = new AssetReferenceSheet();

        return $sheets;
    }
}
