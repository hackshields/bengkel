<?php

$konsumenData = "";
$konsumen = $model->konsumen;
if ($konsumen != NULL) {
    $kota = $model->konsumen_kota;
    if ($konsumen->wilayahKabupaten != NULL) {
        $kota = $konsumen->wilayahKabupaten->nama;
    }
    $konsumenData = $konsumen->alamat . "<br>" . $kota;
}
echo "<html>\n<body>\n<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n    table.border{\n        /*border-collapse: collapse;\n        border: 1px solid black;*/\n        width: 100%;\n    }\n    table.border td{\n        /*border: 1px solid black;*/\n        padding: 5px 10px;\n    }\n    .smalldiv {\n        font-size: 11px;\n    }\n</style>\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 35%;vertical-align: top\">\n            <table>\n                <tr>\n                    <td style=\"text-align: right;vertical-align: top\">No NSC:</td>\n                    <td style=\"text-align: left;vertical-align: top\">\n                        ";
echo $model->no_nsc;
echo "                        <br>\n                        ";
echo app\components\Tanggal::toReadableDate($model->tanggal_pengeluaran);
echo " [";
echo $model->pengeluaranPartTipe->nama;
echo "]\n                    </td>\n                </tr>\n            </table>\n            <div style=\"clear:both\" />\n        </td>\n        <td style=\"width: 30%;text-align: right;vertical-align: top\">\n            <table style=\"float: right\">\n                <tr>\n                    <td style=\"text-align: right;vertical-align: top\">Kepada Yth</td>\n                    <td style=\"text-align: left;vertical-align: top\">\n                        ";
echo $model->konsumen_nama;
echo "                        <br>\n                        ";
echo $konsumenData;
echo "                    </td>\n                    <td style=\"text-align: left;vertical-align: top\">\n                        &nbsp;\n                        <br>\n                        &nbsp;\n                        <br>\n                        ";
echo $konsumen->konsumenGroup ? $konsumen->konsumenGroup->nama : "&nbsp;";
echo "                    </td>\n                </tr>\n            </table>\n            <div style=\"clear:both\" />\n        </td>\n    </tr>\n</table>\n<hr>\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0\" class=\"border\">\n    <tr>\n        <td style=\"text-align: center\">NO.</td>\n        <td>DESKRIPSI</td>\n        <td style=\"text-align: right\">HARGA</td>\n        <td style=\"text-align: center\">QTY</td>\n        <td style=\"text-align: center\">DISC.%</td>\n        <td style=\"text-align: center\">DISC.RP</td>\n        <td style=\"text-align: right\">JML</td>\n    </tr>\n    ";
$total = array();
foreach (app\models\BebanPembayaran::find()->all() as $beban) {
    $total[$beban->nama] = 0;
}
$no = 1;
foreach ($model->pengeluaranPartDetails as $detail) {
    echo "        <tr>\n            <td style=\"text-align: center\">";
    echo $no++;
    echo "</td>\n            <td>";
    echo $detail->sukuCadang->nama;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($detail->het, false);
    echo "</td>\n            <td style=\"text-align: center\">";
    echo app\components\Angka::toReadableAngka($detail->quantity, false);
    echo "</td>\n            <td style=\"text-align: center\">";
    echo app\components\Angka::toReadableAngka($detail->diskon_p, false);
    echo "</td>\n            <td style=\"text-align: center\">";
    echo app\components\Angka::toReadableAngka($detail->diskon_r, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($detail->total, false);
    echo "</td>\n        </tr>\n    ";
    if ($detail->beban_pembayaran_id == app\models\BebanPembayaran::CASH) {
        $total[$detail->bebanPembayaran->nama] += $detail->total;
    } else {
        $total[$detail->bebanPembayaran->nama] += $detail->harga;
    }
}
echo "</table>\n<hr>\n<div class=\"smalldiv\">\nKeterangan : ";
echo $model->catatan;
echo "</div>\n<hr>\n\n";
$activeFrontDesk = app\models\User::getFrontDesk();
$activeKasir = app\models\User::getKasir();
echo "\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"vertical-align: top;text-align: center\">\n            Front Desk\n            <br>\n            <br>\n            <br>\n            ";
echo $activeFrontDesk->name;
echo "        </td>\n        <td style=\"vertical-align: top;text-align: center\">\n            Kasir\n            <br>\n            <br>\n            <br>\n            ";
echo $activeKasir->name;
echo "        </td>\n        <td style=\"vertical-align: top;text-align: center\">\n            Konsumen\n            <br>\n            <br>\n            <br>\n            ";
echo $model->konsumen_nama;
echo "        </td>\n        <td style=\"vertical-align: top\">\n            Total Pembelian\n            <br>\n            ";
$grandTotal = 0;
foreach ($total as $key => $val) {
    $grandTotal += $val;
    echo $key . "<br>";
}
echo "        </td>\n        <td style=\"text-align: right;vertical-align: top\">\n            ";
echo app\components\Angka::toReadableAngka($grandTotal, false);
echo "            <br>\n            ";
foreach ($total as $key => $val) {
    echo app\components\Angka::toReadableAngka($val, false) . "<br>";
}
echo "        </td>\n    </tr>\n</table>\n<div style=\"text-align: right\">\n    # ";
echo strtoupper(app\components\Angka::toTerbilang($grandTotal));
echo " RUPIAH #\n</div>\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 50%;vertical-align: bottom;font-size: 8px !important;\">\n            BERLAKU SEBAGAI FAKTUR PAJAK SEDERHANA DAN SUDAH TERMASUK PPN\n        </td>\n        <td style=\"vertical-align: top;text-align: right\">\n\n            <div style=\"text-align: center;font-size: 8px !important;\">\n                CETAKAN KE-";
echo $model->nomor_cetak;
echo " ";
echo date("d/m/Y H:i:s");
echo "            </div>\n        </td>\n    </tr>\n</table>\n<hr>\n</body>\n</html>\n";

?>