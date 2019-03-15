<?php

$nilaiSistem = 0;
$nilaiSelisih = 0;
$nilaiStock = 0;
echo "<html>\n<body>\n<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n\n    table.border{\n        border-collapse: collapse;\n        border: 1px solid black;\n        width: 100%;\n    }\n    table.border td{\n        border: 1px solid black;\n        padding: 5px 10px;\n    }\n</style>\n<table>\n    <tr>\n        <td>\n            Kode Koreksi\n        </td>\n        <td>\n            : ";
echo $model->no_opname;
echo "        </td>\n    </tr>\n    <tr>\n        <td>\n            Tanggal\n        </td>\n        <td>\n            : ";
echo app\components\Tanggal::toReadableDate($model->tanggal_opname);
echo "        </td>\n    </tr>\n    <tr>\n        <td>\n            Petugas\n        </td>\n        <td>\n            : ";
echo $model->petugas->name;
echo "        </td>\n    </tr>\n</table>\n<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 20px 0\" class=\"border\">\n    <tr>\n        <td>NO.</td>\n        <td>KODE</td>\n        <td>SUKU CADANG</td>\n        <td style=\"text-align: right\">Qty System</td>\n        <td style=\"text-align: right\">Qty Selisih</td>\n        <td style=\"text-align: right\">Stok Akhir</td>\n        <td style=\"text-align: right\">Harga Pokok</td>\n        <td>LOKASI RAK</td>\n    </tr>\n    ";
$no = 1;
foreach ($model->stockOpnameDetails as $detail) {
    $hpp = $detail->sukuCadang->sukuCadangJaringan->hpp;
    echo "        <tr>\n            <td>";
    echo $no++;
    echo "</td>\n            <td>";
    echo $detail->sukuCadang->kode;
    echo "</td>\n            <td>";
    echo $detail->sukuCadang->nama;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($detail->quantity_sy);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($detail->quantity_oh - $detail->quantity_sy);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($detail->quantity_oh);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($hpp, false);
    echo "</td>\n            <td>";
    echo $detail->keterangan;
    echo "</td>\n        </tr>\n    ";
    $nilaiSistem += $detail->quantity_sy * $hpp;
    $nilaiSelisih += ($detail->quantity_oh - $detail->quantity_sy) * $hpp;
    $nilaiStock += $detail->quantity_oh * $hpp;
}
echo "</table>\n\n<table style=\"margin-bottom: 20px;width:300px\">\n    <tr>\n        <td>Nilai Stock By System</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($nilaiSistem);
echo "</td>\n    </tr>\n    <tr>\n        <td>Nilai Selisih</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($nilaiSelisih);
echo "</td>\n    </tr>\n    <tr>\n        <td>Nilai Stock</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($nilaiStock);
echo "</td>\n    </tr>\n</table>\n\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 30%;text-align: center;vertical-align: top\">\n            <br>\n            Mengetahui,\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ( _________________________ )\n        </td>\n        <td style=\"width: 40%;text-align: center;vertical-align: top\">\n            <br>\n            Dibuat Oleh\n        </td>\n        <td style=\"width: 30%;text-align: center;vertical-align: top\">\n            Tanggal Cetak : ";
echo app\components\Tanggal::toReadableDate(date("Y-m-d"));
echo "            <br>\n            Menyetujui,\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ( _________________________ )\n        </td>\n    </tr>\n</table>\n\n</body>\n</html>\n";

?>