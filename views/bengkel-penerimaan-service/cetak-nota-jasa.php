<?php

$jaringan = app\models\Jaringan::find()->where(array("id" => app\models\Jaringan::getCurrentID()))->one();
$notaJasa = app\models\NotaJasa::find()->where(array("perintah_kerja_id" => $model->id))->one();
$notaSukuCadang = app\models\PengeluaranPart::find()->where(array("no_referensi" => $model->id))->one();
echo "<html>\n<body>\n<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n\n    table.border {\n        border-collapse: collapse;\n        border: 1px solid black;\n        width: 100%;\n    }\n\n    table.border td {\n        border: 1px solid black;\n        padding: 5px 10px;\n    }\n</style>\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 50%;vertical-align: top\">\n            <table style=\"width: 100%\">\n                <tr>\n                    <td>No PKB</td>\n                    <td>:</td>\n                    <td>";
echo $model->nomor;
echo "</td>\n                </tr>\n                <tr>\n                    <td>Nopol</td>\n                    <td>:</td>\n                    <td>\n                        ";
echo $model->konsumen->nopol;
echo "                        -\n                        ";
echo app\components\Tanggal::toReadableDate($model->waktu_daftar, false, true);
echo "                    </td>\n                </tr>\n            </table>\n        </td>\n        <td style=\"width: 50%;text-align: right;vertical-align: top\">\n            <table style=\"float: right\">\n                <tr>\n                    <td style=\"text-align: right;vertical-align: top\">Kepada Yth</td>\n                    <td style=\"text-align: left;vertical-align: top\">\n                        ";
echo $model->konsumen->nama;
echo "                        <br>\n                        ";
echo $model->konsumen->alamat;
echo "                        <br>\n                        ";
echo $model->konsumen->wilayahKabupaten->nama;
echo "                        <br>\n                        ";
echo $konsumen->konsumenGroup ? $konsumen->konsumenGroup->nama : "UMUM";
echo "                    </td>\n                </tr>\n            </table>\n        </td>\n    </tr>\n</table>\n<hr/>\n<h3>Nota Ref : ";
echo $notaJasa->nomor;
echo "</h3>\n";
$no = 1;
echo "<table style=\"width: 100%\">\n    <tr>\n        <td style=\"\">Keterangan</td>\n        <td style=\"width: 10%;text-align: center\">Qty</td>\n        <td style=\"width: 15%;text-align: right\">Harga</td>\n        <td style=\"width: 10%;text-align: center\">Disc</td>\n        <td style=\"width: 15%;text-align: right\">Total</td>\n    </tr>\n    ";
$totalJasa = 0;
foreach ($notaJasa->notaJasaDetails as $pkbJasa) {
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
    $totalJasa += $pkbJasa->total;
}
echo "</table>\n<hr>\nCatatan :\n";
echo $model->catatan;
echo "<hr>\n\n";
$activeFrontdesk = app\models\User::getFrontDesk();
$activeKasir = app\models\User::getKasir();
echo "\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 20%;text-align: center;vertical-align: top\">\n            Front Desk\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ";
echo $activeFrontdesk->name;
echo "        </td>\n        <td style=\"width: 20%;text-align: center;vertical-align: top\">\n            Kasir\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ";
echo $activeKasir->name;
echo "        </td>\n        <td style=\"width: 20%;text-align: center;vertical-align: top\">\n            Konsumen\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ";
echo $model->konsumen->nama;
echo "        </td>\n        <td style=\"width: 25%;vertical-align: bottom\">\n            <b>Total Pembayaran :</b>\n        </td>\n        <td style=\"vertical-align: bottom;text-align: right\">\n            ";
echo app\components\Angka::toReadableHarga($totalJasa);
echo "        </td>\n    </tr>\n</table>\n\n<hr/>\n\n<div style=\"text-align: right\">\n    # ";
echo strtoupper(app\components\Angka::toTerbilang($totalJasa));
echo " RUPIAH #\n</div>\n<hr/>\n<div style=\"font-size: 10\">\n    # GARANSI SERVICE : 500 KM ATAU 7 HARI MANA YANG TERCAPAI LEBIH DAHULU #\n    <hr/>\n    <div style=\"text-align: right\">\n        # CETAKAN KE-";
echo $notaJasa->nomor_cetak;
echo "  ";
echo date("d/m/Y H:i:s");
echo " #\n    </div>\n</body>\n</html>\n";
$notaJasa->nomor_cetak += 1;
$notaJasa->save();

?>