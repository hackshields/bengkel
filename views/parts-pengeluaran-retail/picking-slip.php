<?php

echo "<html>\n<body>\n<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n\n    table.border{\n        /*border-collapse: collapse;\n        border: 1px solid black;*/\n        width: 100%;\n    }\n    table.border td{\n        /*border: 1px solid black;*/\n        padding: 5px 10px;\n    }\n</style>\n\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 35%;vertical-align: top\">\n            <table>\n                <tr>\n                    <td style=\"text-align: right;vertical-align: top\">No NSC:</td>\n                    <td style=\"text-align: left;vertical-align: top\">\n                        ";
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
echo "                    </td>\n                </tr>\n            </table>\n            <div style=\"clear:both\" />\n        </td>\n    </tr>\n</table>\n\n<hr />\n\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0\" class=\"border\">\n    <tr>\n        <td style=\"text-align: center\">NO.</td>\n        <td>KODE PART</td>\n        <td>DESKRIPSI</td>\n        <td style=\"text-align: center\">QTY</td>\n        <td>LOKASI</td>\n    </tr>\n    ";
$no = 1;
foreach ($model->pengeluaranPartDetails as $detail) {
    echo "        <tr>\n            <td style=\"text-align: center\">";
    echo $no++;
    echo "</td>\n            <td>";
    echo $detail->sukuCadang->kode;
    echo "</td>\n            <td>";
    echo $detail->sukuCadang->nama;
    echo "</td>\n            <td style=\"text-align: center\">";
    echo app\components\Angka::toReadableAngka($detail->quantity, false);
    echo "</td>\n            <td>";
    echo $detail->rak->nama;
    echo "</td>\n        </tr>\n    ";
}
echo "</table>\n<hr>\n\n";
$activeFrontDesk = app\models\User::getFrontDesk();
$activeKasir = app\models\User::getKasir();
echo "\n<table>\n    <tr>\n        <td style=\"vertical-align: top;text-align: center\">\n            Front Desk\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ";
echo $activeFrontDesk->name;
echo "        </td>\n        <td style=\"vertical-align: top;text-align: center\">\n            Petugas Gudang\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n        </td>\n    </tr>\n</table>\n\n<div style=\"font-size: 8px !important;\">\n    CETAKAN KE-";
echo $model->nomor_cetak;
echo " ";
echo date("d/m/Y H:i:s");
echo "</div>\n<hr />\n</body>\n</html>\n";

?>