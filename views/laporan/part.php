<?php

$tanggal1 = $_GET["tanggal1"];
$tanggal2 = $_GET["tanggal2"];
$time1 = $tanggal1 . " 00:00:00";
$time2 = $tanggal2 . " 23:59:59";
echo "<html>\n<head>\n    <style>\n        body {\n            font-family: \"Courier New\", Courier, monospace;\n            font-size: 12px;\n        }\n\n        td {\n            padding-left: 5px;\n            padding-right: 5px;\n            font-size: 11px;\n        }\n    </style>\n</head>\n<body>\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 5%;text-align: center\">No</td>\n        <td style=\"text-align: center\">SUKU CADANG</td>\n        <td style=\"width: 10%;text-align: center\">QTY SALES</td>\n        <td style=\"width: 10%;text-align: center\">HARGA POKOK</td>\n        <td style=\"width: 10%;text-align: center\">HARGA AVG JUAL</td>\n        <td style=\"width: 10%;text-align: center\">TOTAL DISKON</td>\n        <td style=\"width: 10%;text-align: center\">TOTAL SALES</td>\n        <td style=\"width: 10%;text-align: center\">PROFIT MARGIN</td>\n    </tr>\n    ";
$total = array();
foreach (app\models\BebanPembayaran::find()->all() as $beban) {
    $total[$beban->nama] = 0;
}
StaticData::$tanggal1 = $tanggal1;
StaticData::$tanggal2 = $tanggal2;
$no = 1;
$nscList = app\models\PengeluaranPartDetail::find()->joinWith(array("pengeluaranPart" => function ($nscQuery) {
    $nscQuery->where("tanggal_pengeluaran >= '" . StaticData::$tanggal1 . "' AND tanggal_pengeluaran <= '" . StaticData::$tanggal2 . "'")->andWhere(array("pengeluaran_part.jaringan_id" => app\models\Jaringan::getCurrentID()));
}))->all();
$data = array();
foreach ($nscList as $nsc) {
    $sc = $nsc->sukuCadang;
    $key = $sc->kode . "-" . $sc->nama;
    if (!isset($data[$key])) {
        $data[$key] = array("suku_cadang" => "[" . $sc->kode . "] " . $sc->nama, "quantity" => 0, "harga_pokok" => 0, "harga_avg_jual" => 0, "total_diskon" => 0, "total_sales" => 0, "profit_margin" => 0);
    }
    $data[$key]["quantity"] += $nsc->quantity;
    $data[$key]["harga_pokok"] += $nsc->hpp;
    $data[$key]["harga_avg_jual"] += $nsc->het;
    $data[$key]["total_diskon"] += $nsc->diskon;
    $data[$key]["total_sales"] += $nsc->total;
    $data[$key]["profit_margin"] += $nsc->total - ($nsc->het * $nsc->quantity - ($nsc->hpp * $nsc->quantity + $nsc->diskon));
}
usort($data, function ($a, $b) {
    if ($a["quantity"] == $b["quantity"]) {
        return 0;
    }
    return $b["quantity"] < $a["quantity"] ? -1 : 1;
});
$grandTotal = array("quantity" => 0, "total_sales" => 0, "profit_margin" => 0);
foreach ($data as $key => $value) {
    echo "        <tr>\n            <td style=\"text-align: center\">";
    echo $no++;
    echo "</td>\n            <td style=\"text-align: left\">";
    echo $value["suku_cadang"];
    echo "</td>\n            <td style=\"text-align: center\">";
    echo app\components\Angka::toReadableAngka($value["quantity"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($value["harga_pokok"] / $value["quantity"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($value["harga_pokok"] / $value["quantity"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($value["total_diskon"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($value["total_sales"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($value["profit_margin"], false);
    echo "</td>\n        </tr>\n        ";
    $grandTotal["quantity"] += $value["quantity"];
    $grandTotal["total_sales"] += $value["total_sales"];
    $grandTotal["profit_margin"] += $value["profit_margin"];
}
echo "    <tr style=\"background: #cccccc\">\n        <td colspan=\"2\">TOTAL</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["quantity"], false);
echo "</td>\n        <td colspan=\"3\"></td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["total_sales"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["profit_margin"], false);
echo "</td>\n    </tr>\n</table>\n</body>\n</html>\n";
class StaticData
{
    public static $tanggal1 = NULL;
    public static $tanggal2 = NULL;
}

?>