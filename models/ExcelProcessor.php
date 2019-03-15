<?php

namespace app\models;

class ExcelProcessor extends \yii\base\Model
{
    public $excelFilePath = NULL;
    public $table = NULL;
    public $sheet = NULL;
    public $sheetList = array();
    public function rules()
    {
        return array();
    }
    public function getTableList()
    {
        return array("supplier" => "Supplier", "konsumen" => "Konsumen", "sukuCadang" => "Suku Cadang", "jasa" => "Jasa Servis", "karyawan" => "Karyawan", "penerimaan" => "Penerimaan Suku Cadang", "penerimaanDetail" => "Detail Penerimaan Suku Cadang", "pengeluaran" => "Pengeluaran Suku Cadang", "pengeluaranDetail" => "Detail Pengeluaran Suku Cadang", "stockOpname" => "Stock Opname", "detailStockOpname" => "Detail Stock Opname", "absensi" => "Absensi", "perintahKerja" => "Perintah Kerja", "perintahKerjaDetailJasa" => "Detail Perintah Kerja Jasa", "perintahKerjaDetailPart" => "Detail Perintah Kerja Part", "notaJasa" => "Nota Jasa", "notaJasaDetail" => "Detail Nota Jasa");
    }
    public function getSheetList()
    {
        return $this->sheetList;
    }
    public function process()
    {
        if ($this->validate()) {
            return true;
        }
        return false;
    }
}

?>