<?php

$tanggal1 = $_GET["tanggal1"];
$tanggal2 = $_GET["tanggal2"];
$time1 = $tanggal1 . " 00:00:00";
$time2 = $tanggal2 . " 23:59:59";
$mekaniks = app\models\User::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID(), "role_id" => app\models\Role::MEKANIK))->all();
echo "<html>\n<head>\n    <style>\n        body {\n            font-family: \"Courier New\", Courier, monospace;\n            font-size: 12px;\n        }\n\n        td {\n            padding-left: 5px;\n            padding-right: 5px;\n            font-size: 11px;\n        }\n    </style>\n</head>\n<body>\n<table style=\"width: 100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n    <tr>\n        <td style=\"text-align: center;width: 4%\" rowspan=\"2\">No</td>\n        <td style=\"text-align: center\" rowspan=\"2\">MEKANIK</td>\n        <td style=\"text-align: center\" colspan=\"4\">AFTER SALES SERVICE</td>\n        <td style=\"text-align: center;width: 6%\" rowspan=\"2\">CLAIM</td>\n        <td style=\"text-align: center\" colspan=\"3\">QUICK SERVICE</td>\n        <td style=\"text-align: center;width: 6%\" rowspan=\"2\">LR</td>\n        <td style=\"text-align: center;width: 6%\" rowspan=\"2\">HR</td>\n        <td style=\"text-align: center;width: 6%\" rowspan=\"2\">JR</td>\n        <td style=\"text-align: center;width: 6%\" rowspan=\"2\">TOTAL NILAI</td>\n    </tr>\n    <tr>\n        <td style=\"text-align: center;width: 6%\">1</td>\n        <td style=\"text-align: center;width: 6%\">2</td>\n        <td style=\"text-align: center;width: 6%\">3</td>\n        <td style=\"text-align: center;width: 6%\">4</td>\n        <td style=\"text-align: center;width: 6%\">CS</td>\n        <td style=\"text-align: center;width: 6%\">LS</td>\n        <td style=\"text-align: center;width: 6%\">G.OLI</td>\n    </tr>\n    ";
$totalass1 = 0;
$totalass2 = 0;
$totalass3 = 0;
$totalass4 = 0;
$totalclaim = 0;
$totalcs = 0;
$totalls = 0;
$totalgantioli = 0;
$totallr = 0;
$totalhr = 0;
$totaljr = 0;
$totaltotal = 0;
$no = 1;
foreach ($mekaniks as $mekanik) {
    $ass1 = 0;
    $ass2 = 0;
    $ass3 = 0;
    $ass4 = 0;
    $claim = 0;
    $cs = 0;
    $ls = 0;
    $gantioli = 0;
    $lr = 0;
    $hr = 0;
    $jr = 0;
    $total = 0;
    $pkbs = app\models\PerintahKerja::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID(), "karyawan_id" => $mekanik->id))->andWhere("waktu_daftar between '" . $time1 . "' and '" . $time2 . "'")->all();
    foreach ($pkbs as $pkb) {
        foreach ($pkb->notaJasas as $notaJasa) {
            foreach ($notaJasa->notaJasaDetails as $detail) {
                $jasa = $detail->jasa;
                if ($jasa->jasa_group_id == app\models\JasaGroup::ASS1) {
                    $ass1 += $detail->harga;
                } else {
                    if ($jasa->jasa_group_id == app\models\JasaGroup::ASS2) {
                        $ass2 += $detail->harga;
                    } else {
                        if ($jasa->jasa_group_id == app\models\JasaGroup::ASS3) {
                            $ass3 += $detail->harga;
                        } else {
                            if ($jasa->jasa_group_id == app\models\JasaGroup::ASS4) {
                                $ass4 += $detail->harga;
                            } else {
                                if ($jasa->jasa_group_id == app\models\JasaGroup::CL) {
                                    $claim += $detail->harga;
                                } else {
                                    if ($jasa->jasa_group_id == app\models\JasaGroup::PL) {
                                        $cs += $detail->harga;
                                    } else {
                                        if ($jasa->jasa_group_id == app\models\JasaGroup::PR) {
                                            $ls += $detail->harga;
                                        } else {
                                            if ($jasa->jasa_group_id == app\models\JasaGroup::GO) {
                                                $gantioli += $detail->harga;
                                            } else {
                                                if ($jasa->jasa_group_id == app\models\JasaGroup::LR) {
                                                    $lr += $detail->harga;
                                                } else {
                                                    if ($jasa->jasa_group_id == app\models\JasaGroup::HR) {
                                                        $hr += $detail->harga;
                                                    } else {
                                                        if ($jasa->jasa_group_id == app\models\JasaGroup::JR) {
                                                            $jr += $detail->harga;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $total += $detail->harga;
            }
        }
    }
    echo "        <tr>\n            <td style=\"text-align: center\">";
    echo $no++;
    echo "</td>\n            <td style=\"text-align: left\">";
    echo $mekanik->name;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($ass1, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($ass2, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($ass3, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($ass4, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($claim, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($cs, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($ls, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($gantioli, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($lr, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($hr, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($jr, false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($total, false);
    echo "</td>\n        </tr>\n        ";
    $totalass1 += $ass1;
    $totalass2 += $ass2;
    $totalass3 += $ass3;
    $totalass4 += $ass4;
    $totalclaim += $claim;
    $totalcs += $cs;
    $totalls += $ls;
    $totalgantioli += $gantioli;
    $totallr += $lr;
    $totalhr += $hr;
    $totaljr += $jr;
    $totaltotal += $total;
}
echo "    <tr>\n        <td style=\"text-align: center\"></td>\n        <td style=\"text-align: left\">TOTAL</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalass1, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalass2, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalass3, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalass4, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalclaim, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalcs, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalls, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalgantioli, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totallr, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalhr, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totaljr, false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totaltotal, false);
echo "</td>\n    </tr>\n</table>\n</body>\n</html>\n";

?>