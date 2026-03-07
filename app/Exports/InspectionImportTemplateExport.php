<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\InspectionTemplateSheet;
use App\Exports\Sheets\AssetListReferenceSheet;

class InspectionImportTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new InspectionTemplateSheet(),
            new AssetListReferenceSheet(),
        ];
    }
}
