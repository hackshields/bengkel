<?php

$jaringan = app\models\Jaringan::find()->where(array("id" => app\models\Jaringan::getCurrentID()))->one();
$pkb = $model->perintahKerja;
$konsumen = $pkb->konsumen;
echo "<html>\n<body>\n<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n\n    table.border {\n        border-collapse: collapse;\n        border: 1px solid black;\n        width: 100%;\n    }\n\n    table.border td {\n        border: 1px solid black;\n        padding: 5px 10px;\n    }\n</style>\n\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 50%;vertical-align: top\">\n            <table style=\"width: 100%\">\n                <tr>\n                    <td>No PKB</td>\n                    <td>:</td>\n                    <td>";
echo $pkb->nomor;
echo "</td>\n                </tr>\n                <tr>\n                    <td>Nopol</td>\n                    <td>:</td>\n                    <td>\n                        ";
echo $pkb->konsumen->nopol;
echo "                        -\n                        ";
echo app\components\Tanggal::toReadableDate($pkb->waktu_daftar, false, true);
echo "                    </td>\n                </tr>\n            </table>\n        </td>\n        <td style=\"width: 50%;text-align: right;vertical-align: top\">\n            <table style=\"float: right\">\n                <tr>\n                    <td style=\"text-align: right;vertical-align: top\">Kepada Yth</td>\n                    <td style=\"text-align: left;vertical-align: top\">\n                        ";
echo $pkb->konsumen->nama;
echo "                        <br>\n                        ";
echo $pkb->konsumen->alamat;
echo "                        <br>\n                        ";
echo $pkb->konsumen->wilayahKabupaten->nama;
echo "                        <br>\n                        ";
echo $konsumen->konsumenGroup ? $konsumen->konsumenGroup->nama : "UMUM";
echo "                    </td>\n                </tr>\n            </table>\n        </td>\n    </tr>\n</table>\n<hr/>\n";
$no = 1;
echo "<table style=\"width: 100%\">\n    <tr>\n        <td style=\"\">Keterangan</td>\n        <td style=\"width: 10%;text-align: center\">Qty</td>\n        <td style=\"width: 15%;text-align: right\">Harga</td>\n        <td style=\"width: 10%;text-align: center\">Disc</td>\n        <td style=\"width: 15%;text-align: right\">Total</td>\n    </tr>\n    ";
$total = array();
foreach (app\models\BebanPembayaran::find()->all() as $beban) {
    $total[$beban->nama] = 0;
}
$totalJasa = 0;
foreach ($model->notaJasaDetails as $pkbJasa) {
    echo "        <tr>\n            <td>";
    echo $pkbJasa->jasa->nama;
    echo "</td>\n            <td style=\"text-align: center\">1</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($pkbJasa->harga);
    echo "</td>\n            <td style=\"text-align: center\">\n                ";
    if ($pkbJasa->diskon_p != 0) {
        echo $pkbJasa->diskon_p . " %";
    } else {
        echo $pkbJasa->diskon_r;
    }
    echo "            </td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($pkbJasa->total);
    echo "</td>\n        </tr>\n        ";
    $totalJasa += $pkbJasa->harga;
    if ($pkbJasa->beban_pembayaran_id == app\models\BebanPembayaran::CASH) {
        $total[$pkbJasa->bebanPembayaran->nama] += $pkbJasa->total;
    } else {
        $total[$pkbJasa->bebanPembayaran->nama] += $pkbJasa->harga;
    }
}
echo "</table>\n<hr>\nCatatan :\n";
echo $model->catatan;
echo "<hr>\n\n";
$activeFrontdesk = app\models\User::getFrontDesk();
$activeKasir = app\models\User::getKasir();
echo "\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 20%;text-align: center;vertical-align: top\">\n            Front Desk\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ";
echo $activeFrontdesk->name;
echo "        </td>\n        <td style=\"width: 20%;text-align: center;vertical-align: top\">\n            Kasir\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ";
echo $activeFrontdesk->name;
echo "        </td>\n        <td style=\"width: 20%;text-align: center;vertical-align: top\">\n            Konsumen\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ";
echo $konsumen->nama;
echo "        </td>\n        <td style=\"vertical-align: bottom\">\n            <table style=\"width: 100%\">\n                ";
$grandTotal = 0;
foreach ($total as $key => $val) {
    $grandTotal += $val;
    echo "                    <tr>\n                        <td style=\"width: 40%\">";
    echo $key;
    echo "</td>\n                        <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableHarga($val, false);
    echo "</td>\n                    </tr>\n                ";
}
echo "                <tr>\n                    <td style=\"width: 40%\">TOTAL</td>\n                    <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($grandTotal, false);
echo "</td>\n                </tr>\n            </table>\n        </td>\n    </tr>\n</table>\n\n<hr/>\n\n<div style=\"text-align: right\">\n    # ";
echo strtoupper(app\components\Angka::toTerbilang($grandTotal));
echo " RUPIAH #\n</div>\n<hr/>\n<div style=\"font-size: 11px\">\n    # GARANSI SERVICE : 500 KM ATAU 7 HARI MANA YANG TERCAPAI LEBIH DAHULU #\n</div>\n<hr/>\n<div style=\"text-align: right;font-size: 11px\">\n    # CETAKAN KE-";
echo $model->nomor_cetak;
echo " ";
echo date("d/m/Y H:i:s");
echo " #\n</div>\n</body>\n</html>\n\n";
$model->nomor_cetak += 1;
$model->save();

?>