<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\DisposalTemplateSheet;
use App\Exports\Sheets\AssetListReferenceSheet;

class DisposalImportTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new DisposalTemplateSheet(),
            new AssetListReferenceSheet(),
        ];
    }
}
