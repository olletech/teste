<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php'; // Caminho correto para o autoload do Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PhpSpreadsheet_lib
{

  public function exportToExcel($data, $fileName, $download = true)
  {
    // Criando planilha
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Adiciona cabeçalhos
    $column = 1;
    foreach (array_keys($data[0]) as $key) {
      $sheet->setCellValueByColumnAndRow($column, 1, $key);
      $column++;
    }

    // Adiciona os dados
    $row = 2;
    foreach ($data as $record) {
      $column = 1;
      foreach ($record as $value) {
        $sheet->setCellValueByColumnAndRow($column, $row, $value);
        $column++;
      }
      $row++;
    }

    // Define tipo de arquivo
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    ob_start();
    $writer->save('php://output');
    $excelData = ob_get_clean();

    return $excelData;
  }
}