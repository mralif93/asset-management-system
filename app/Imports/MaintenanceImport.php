<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class MaintenanceImport implements ToArray
{
    public function array(array $array)
    {
        return $array;
    }
}
