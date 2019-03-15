<?php

$tanggal1 = $_GET["tanggal1"];
$tanggal2 = $_GET["tanggal2"];
$time1 = $tanggal1 . " 00:00:00";
$time2 = $tanggal2 . " 23:59:59";
echo "<html>\n<head>\n    <style>\n        body {\n            font-family: \"Courier New\", Courier, monospace;\n            font-size: 12px;\n        }\n\n        td {\n            padding-left: 5px;\n            padding-right: 5px;\n            font-size: 11px;\n        }\n    </style>\n</head>\n<body>\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 5%;text-align: center\" rowspan=\"2\">No</td>\n        <td style=\"width: 10%;text-align: center\" rowspan=\"2\">NOTA</td>\n        <td style=\"width: 5%;text-align: center\" rowspan=\"2\">TGL.</td>\n        <td style=\"width: 10%;text-align: center\" rowspan=\"2\">NO.PKB</td>\n        <td style=\"width: 20%\" rowspan=\"2\">SUKU CADANG</td>\n        <td style=\"width: 10%;text-align: center\" rowspan=\"2\">TIPE BAYAR</td>\n        <td style=\"text-align: center\" colspan=\"5\">DETIL NOTA</td>\n    </tr>\n    <tr>\n        <td style=\"width: 8%;text-align: center\">QTY</td>\n        <td style=\"width: 8%;text-align: center\">JUMLAH</td>\n        <td style=\"width: 8%;text-align: center\">DISC.%</td>\n        <td style=\"width: 8%;text-align: center\">DISC.Rp</td>\n        <td style=\"width: 8%;text-align: center\">TOTAL</td>\n    </tr>\n    ";
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
foreach ($nscList as $nsc) {
    echo "        <tr>\n            <td style=\"text-align: center\">";
    echo $no++;
    echo "</td>\n            <td style=\"text-align: center\">";
    echo $nsc->pengeluaranPart->no_nsc;
    echo "</td>\n            <td style=\"text-align: center\">";
    echo date("d/m", strtotime($nsc->pengeluaranPart->tanggal_pengeluaran));
    echo "</td>\n            <td style=\"text-align: center\">";
    echo $nsc->pengeluaranPart->no_referensi ? $nsc->pengeluaranPart->noReferensi->nomor : "-";
    echo "</td>\n            <td style=\"text-align: left\">";
    echo $nsc->sukuCadang->nama;
    echo "</td>\n            <td style=\"text-align: center\">";
    echo $nsc->bebanPembayaran->nama;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($nsc->quantity, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($nsc->het, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo $nsc->diskon_p;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($nsc->diskon_r, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($nsc->total, false);
    echo "</td>\n        </tr>\n        ";
    if ($nsc->beban_pembayaran_id == app\models\BebanPembayaran::CASH) {
        $total[$nsc->bebanPembayaran->nama] += $nsc->total;
    } else {
        $total[$nsc->bebanPembayaran->nama] += $nsc->het;
    }
}
echo "</table>\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n    ";
$grandTotal = 0;
foreach ($total as $key => $val) {
    $grandTotal += $val;
    echo "        <tr>\n            <td style=\"width: 40%\">";
    echo $key;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableHarga($val, false);
    echo "</td>\n        </tr>\n    ";
}
echo "    <tr>\n        <td style=\"width: 40%\">TOTAL</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($grandTotal, false);
echo "</td>\n    </tr>\n</table>\n</body>\n</html>\n";
class StaticData
{
    public static $tanggal1 = NULL;
    public static $tanggal2 = NULL;
}

?>