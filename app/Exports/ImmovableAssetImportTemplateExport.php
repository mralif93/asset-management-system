<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\ImmovableAssetTemplateSheet;
use App\Exports\Sheets\ImmovableAssetReferenceSheet;

class ImmovableAssetImportTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ImmovableAssetTemplateSheet(),
            new ImmovableAssetReferenceSheet(),
        ];
    }
}
