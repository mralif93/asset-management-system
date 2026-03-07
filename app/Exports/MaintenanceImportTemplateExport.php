<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\MaintenanceTemplateSheet;
use App\Exports\Sheets\AssetListReferenceSheet;

class MaintenanceImportTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new MaintenanceTemplateSheet(),
            new AssetListReferenceSheet(),
        ];
    }
}
