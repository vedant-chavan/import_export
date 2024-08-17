<?php

namespace App\Imports;

use App\Models\ImportData;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportFile implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $excelDate = (float) $row['date_of_installation'];
    
        if (is_numeric($excelDate)) {
            $unixTimestamp = ($excelDate - 25569) * 86400; // Convert Excel date to Unix timestamp
                    $date = date("Y-m-d", $unixTimestamp);
            // $date = \Carbon\Carbon::createFromFormat('Y-m-d', \Carbon\Carbon::createFromFormat('Y-m-d', '1899-12-30')->addDays($excelDate - 2)->format('Y-m-d'));
        }
        return new ImportData([
            'unique_number' => Str::random(12),
            'date_of_installation' =>  $date ,
            'seal_name' => $row['seal_name'],
            'installed_at' => $row['installed_at'],
            'type' => $row['type'],
            'use' => $row['use'],
            'client' => $row['client'],
        ]);
    }
}
