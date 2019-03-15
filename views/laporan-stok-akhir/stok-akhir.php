<?php

$tanggal1 = $_GET["tanggal1"];
$tanggal2 = $_GET["tanggal2"];
$time1 = $tanggal1 . " 00:00:00";
$time2 = $tanggal2 . " 23:59:59";
echo "<html>\n<head>\n    <style>\n        body {\n            font-family: \"Courier New\", Courier, monospace;\n            font-size: 12px;\n        }\n\n        td {\n            padding-left: 5px;\n            padding-right: 5px;\n            font-size: 11px;\n        }\n    </style>\n</head>\n<body>\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 7%;text-align: center\">No</td>\n        <td style=\"width: 20%;text-align: center\">KODE PART</td>\n        <td style=\"width: 25%;text-align: center\">DESKRIPSI</td>\n        <td style=\"width: 10%;text-align: center\">STOCK</td>\n        <td style=\"width: 10%;text-align: center\">HPP</td>\n        <td style=\"width: 10%;text-align: center\">HET</td>\n        <td style=\"width: 10%;text-align: center\">NILAI</td>\n        <td style=\"width: 10%;text-align: center\">LOKASI</td>\n    </tr>\n    ";
$totalQuantity = 0;
$totalNilai = 0;
$dataStocks = app\models\SukuCadangJaringan::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->joinWith(array("sukuCadang" => function ($query) {
    $query->orderBy("suku_cadang.nama ASC");
}))->all();
foreach ($dataStocks as $sukuCadangJaringan) {
    $sukuCadang = $sukuCadangJaringan->sukuCadang;
    echo "        <tr>\n            <td style=\"text-align: center\">";
    echo $no++;
    echo "</td>\n            <td style=\"text-align: left\">";
    echo $sukuCadang->kode;
    echo "</td>\n            <td style=\"text-align: left\">";
    echo $sukuCadang->nama;
    echo "</td>\n            <td style=\"text-align: center\">";
    echo $sukuCadangJaringan->quantity;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo $sukuCadangJaringan->hpp;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo $sukuCadang->het;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo $sukuCadang->het * $sukuCadangJaringan->quantity;
    echo "</td>\n            <td style=\"text-align: center\">";
    echo $sukuCadangJaringan->rak->nama;
    echo "</td>\n        </tr>\n        ";
    $totalQuantity += $sukuCadangJaringan->quantity;
    $totalNilai += $sukuCadangJaringan->quantity * $sukuCadang->het;
}
echo "</table>\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 40%\">TOTAL JUMLAH SPARE PARTS</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalQuantity, false);
echo "</td>\n    </tr>\n    <tr>\n        <td style=\"width: 40%\">TOTAL NILAI SPARE PARTS</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($totalNilai, false);
echo "</td>\n    </tr>\n</table>\n</body>\n</html>\n";

?>