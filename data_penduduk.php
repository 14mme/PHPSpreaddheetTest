<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$arrayData = [
    ['Nama', 'Usia', 'Alamat', 'Pekerjaan'],
    ['owi',   20,   'Everywhere',   'Tidak ada'],
    ['owo',   21,   'Wakanda',   'Tidak ada'],
    ['kaido',   22,   'Wano',   'Tidak ada'],
    ['luffy',   23,   'East Blue',    'Tidak ada'],
    ['naruto',   24,   'Konoha',    'Tidak ada'],
];

function searchData($arrayData, $column, $value) {
    $columnIndex = array_search($column, $arrayData[0]);

    if ($columnIndex === false) {
        return [];  
    }

    $results = [];
    foreach ($arrayData as $row) {
        if (isset($row[$columnIndex]) && $row[$columnIndex] == $value) {
            $results[] = $row;
        }
    }

    return $results;
}

function exportToFormat($spreadsheet, $format) {
    switch ($format) {
        case 'xlsx':
            $writer = new Xlsx($spreadsheet);
            $filename = 'data_penduduk.xlsx';
            break;

        case 'csv':
            $writer = new Csv($spreadsheet);
            $filename = 'data_penduduk.csv';
            break;

        default:
            echo "Format tidak dikenali.";
            return;
    }

    $writer->save($filename);
    echo "File berhasil diekspor ke $filename\n";
}

$kolomPencarian = 'Nama';  
$nilaiPencarian = 'Q3';    
$searchResults = searchData($arrayData, $kolomPencarian, $nilaiPencarian);

if (!empty($searchResults)) {
    array_unshift($searchResults, $arrayData[0]);  
} else {
    $searchResults = [$arrayData[0]]; 
}

$spreadsheet = new Spreadsheet();
$spreadsheet->getActiveSheet()
    ->fromArray(
        $arrayData,
        NULL,            
        'A1'             
    );


$formatPilihan = 'csv'; 
exportToFormat($spreadsheet, $formatPilihan);