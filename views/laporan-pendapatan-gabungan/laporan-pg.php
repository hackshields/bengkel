<?php

$tanggal1 = $_GET["tanggal1"];
$tanggal2 = $_GET["tanggal2"];
$time1 = $tanggal1 . " 00:00:00";
$time2 = $tanggal2 . " 23:59:59";
$bebanPembayarans = app\models\BebanPembayaran::find()->all();
echo "<html>\n<head>\n    <style>\n        body {\n            font-family: \"Courier New\", Courier, monospace;\n            font-size: 12px;\n        }\n\n        td {\n            padding-left: 5px;\n            padding-right: 5px;\n            font-size: 11px;\n        }\n    </style>\n</head>\n<body>\n<table style=\"width: 100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n    <tr>\n        <td style=\"text-align: center;width: 4%\" rowspan=\"2\">NO</td>\n        <td style=\"text-align: center\" rowspan=\"2\">TANGGAL</td>\n        <td style=\"text-align: center\" colspan=\"";
echo count($bebanPembayarans) + 1;
echo "\">NOTA SUKU CADANG</td>\n        <td style=\"text-align: center\" colspan=\"";
echo count($bebanPembayarans) + 1;
echo "\">NOTA JASA BENGKEL</td>\n        <td style=\"text-align: center;width: 7%\" rowspan=\"2\">TOTAL</td>\n    </tr>\n    <tr>\n        ";
foreach ($bebanPembayarans as $bebanPembayaran) {
    echo "            <td style=\"text-align: center;width: 7%\">";
    echo $bebanPembayaran->nama;
    echo "</td>\n            ";
}
echo "        <td style=\"text-align: center;width: 7%\">Total</td>\n        ";
foreach ($bebanPembayarans as $bebanPembayaran) {
    echo "            <td style=\"text-align: center;width: 7%\">";
    echo $bebanPembayaran->nama;
    echo "</td>\n            ";
}
echo "        <td style=\"text-align: center;width: 7%\">Total</td>\n    </tr>\n    ";
$selisih = abs(strtotime($tanggal2) - strtotime($tanggal1)) / (60 * 60 * 24);
$grandTotal = array();
$grandestTotal = 0;
$no = 1;
for ($i = 0; $i <= $selisih; $i++) {
    $time = strtotime($tanggal1 . " +" . $i . " days");
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . date("d/m/Y", $time) . "</td>";
    $dateTotal = 0;
    $grandIndex = 0;
    $nscTotal = array();
    foreach ($bebanPembayarans as $bebanPembayaran) {
        $nscTotal[$bebanPembayaran->id] = 0;
    }
    $total = 0;
    $nscs = app\models\PengeluaranPart::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID(), "tanggal_pengeluaran" => date("Y-m-d", $time)))->all();
    foreach ($nscs as $nsc) {
        foreach ($nsc->pengeluaranPartDetails as $detail) {
            foreach ($bebanPembayarans as $bebanPembayaran) {
                if ($detail->beban_pembayaran_id == $bebanPembayaran->id) {
                    if ($detail->beban_pembayaran_id == app\models\BebanPembayaran::CASH) {
                        $nscTotal[$detail->beban_pembayaran_id] += $detail->total;
                        $total += $detail->total;
                    } else {
                        $nscTotal[$detail->beban_pembayaran_id] += $detail->het;
                        $total += $detail->het;
                    }
                }
            }
        }
    }
    foreach ($bebanPembayarans as $bebanPembayaran) {
        echo "<td style='text-align: right'>" . app\components\Angka::toReadableAngka($nscTotal[$bebanPembayaran->id], false) . "</td>";
        $grandTotal[$grandIndex++] += $nscTotal[$bebanPembayaran->id];
    }
    echo "<td style='text-align: right'>" . app\components\Angka::toReadableAngka($total, false) . "</td>";
    $grandTotal[$grandIndex++] += $total;
    $dateTotal += $total;
    $njbTotal = array();
    foreach ($bebanPembayarans as $bebanPembayaran) {
        $njbTotal[$bebanPembayaran->id] = 0;
    }
    $total = 0;
    $njbs = app\models\NotaJasa::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID(), "tanggal_njb" => date("Y-m-d", $time)))->all();
    foreach ($njbs as $njb) {
        foreach ($njb->notaJasaDetails as $detail) {
            foreach ($bebanPembayarans as $bebanPembayaran) {
                if ($detail->beban_pembayaran_id == $bebanPembayaran->id) {
                    if ($detail->beban_pembayaran_id == app\models\BebanPembayaran::CASH) {
                        $njbTotal[$detail->beban_pembayaran_id] += $detail->total;
                        $total += $detail->total;
                    } else {
                        $njbTotal[$detail->beban_pembayaran_id] += $detail->harga;
                        $total += $detail->harga;
                    }
                }
            }
        }
    }
    foreach ($bebanPembayarans as $bebanPembayaran) {
        echo "<td style='text-align: right'>" . app\components\Angka::toReadableAngka($njbTotal[$bebanPembayaran->id], false) . "</td>";
        $grandTotal[$grandIndex++] += $njbTotal[$bebanPembayaran->id];
    }
    echo "<td style='text-align: right'>" . app\components\Angka::toReadableAngka($total, false) . "</td>";
    $grandTotal[$grandIndex++] += $total;
    $dateTotal += $total;
    echo "<td style='text-align: right'>" . app\components\Angka::toReadableAngka($dateTotal, false) . "</td>";
    $grandestTotal += $dateTotal;
    echo "</tr>";
}
echo "    <tr>\n        <td colspan=\"2\">TOTAL</td>\n        ";
foreach ($grandTotal as $item) {
    echo "<td style='text-align: right'>" . app\components\Angka::toReadableAngka($item, false) . "</td>";
}
echo "<td style='text-align: right'>" . app\components\Angka::toReadableAngka($grandestTotal, false) . "</td>";
echo "    </tr>\n</table>\n</body>\n</html>\n";

?>