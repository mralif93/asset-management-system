<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\LossWriteoffTemplateSheet;
use App\Exports\Sheets\AssetListReferenceSheet;

class LossWriteoffImportTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new LossWriteoffTemplateSheet(),
            new AssetListReferenceSheet(),
        ];
    }
}
