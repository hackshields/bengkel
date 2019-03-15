<?php

$jaringan = Yii::$app->user->identity->jaringan;
app\components\LbbHelper::setDate($_GET["tanggal1"], $_GET["tanggal2"]);
echo "<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n\n    table.sepedaMotor td {\n        border: 1px solid #000;\n    }\n</style>\n\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 20%\">NO. AHASS</td>\n        <td style=\"width: 30%;border: 1px solid #000\">";
echo $jaringan->kode;
echo "</td>\n        <td style=\"width: 30%\">BULAN LAPORAN</td>\n        <td style=\"width: 20%;border: 1px solid #000\">-</td>\n    </tr>\n    <tr>\n        <td>NAMA AHASS</td>\n        <td style=\"border: 1px solid #000\">";
echo $jaringan->nama;
echo "</td>\n        <td>TGL. DIBUAT</td>\n        <td style=\"border: 1px solid #000\">";
echo app\components\Tanggal::toReadableDate(date("Y-m-d"));
echo "</td>\n    </tr>\n    <tr>\n        <td>KOTA</td>\n        <td style=\"border: 1px solid #000\">";
echo $jaringan->wilayahKabupaten->nama;
echo "</td>\n        <td></td>\n        <td></td>\n    </tr>\n</table>\n\n\n<br>\n\nI. LAPORAN PENDAPATAN BENGKEL\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 50%;vertical-align: top\">\n            <table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n                <tr>\n                    <td colspan=\"2\">\n                        1. PENDAPATAN JASA DAN REPARASI\n                    </td>\n                </tr>\n                ";
$poinA = app\components\LbbHelper::getTotalEntryKPB();
echo "                <tr>\n                    <td style=\"width: 70%\">A. JASA KPB / ASS</td>\n                    <td style=\"width: 30%;text-align: right\">";
echo app\components\Angka::toReadableHarga($poinA);
echo "</td>\n                </tr>\n                ";
$poinB = app\components\LbbHelper::getTotalEntryJasa(app\models\JasaGroup::CL);
echo "                <tr>\n                    <td>B. JASA CLAIM C2</td>\n                    <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($poinB);
echo "</td>\n                </tr>\n                ";
$poinC = app\components\LbbHelper::getTotalEntryJasa(array(app\models\JasaGroup::PR, app\models\JasaGroup::PL));
echo "                <tr>\n                    <td>C. JASA QUICK SERVICE (CS+LS)</td>\n                    <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($poinC);
echo "</td>\n                </tr>\n                ";
$poinD = app\components\LbbHelper::getTotalEntryJasa(app\models\JasaGroup::LR);
echo "                <tr>\n                    <td>D. JASA LIGHT REPAIR (LR)</td>\n                    <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($poinD);
echo "</td>\n                </tr>\n                ";
$poinE = app\components\LbbHelper::getTotalEntryJasa(app\models\JasaGroup::HR);
echo "                <tr>\n                    <td>E. JASA HEAVY REPAIR</td>\n                    <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($poinE);
echo "</td>\n                </tr>\n                ";
$total1 = $poinA + $poinB + $poinC + $poinD + $poinE;
echo "                <tr>\n                    <td>TOTAL - 1</td>\n                    <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($total1);
echo "</td>\n                </tr>\n            </table>\n        </td>\n        <td style=\"width: 50%;vertical-align: top\">\n            <table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n                <tr>\n                    <td colspan=\"2\">\n                        2. PENDAPATAN PENJUALAN PART (SERVICE)\n                    </td>\n                </tr>\n                ";
$sparePart = app\components\LbbHelper::getTotalServiceSparePart();
echo "                <tr>\n                    <td style=\"width: 70%\">A. SPARE PARTS</td>\n                    <td style=\"width: 30%;text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($sparePart);
echo "                    </td>\n                </tr>\n                ";
$oli = app\components\LbbHelper::getTotalServiceOli();
echo "                <tr>\n                    <td>B. OLI</td>\n                    <td style=\"text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($oli);
echo "                    </td>\n                </tr>\n                <tr>\n                    <td>&nbsp;</td>\n                    <td></td>\n                </tr>\n                <tr>\n                    <td>&nbsp;</td>\n                    <td></td>\n                </tr>\n                <tr>\n                    <td>&nbsp;</td>\n                    <td></td>\n                </tr>\n                ";
$total2 = $sparePart + $oli;
echo "                <tr>\n                    <td>TOTAL - 2</td>\n                    <td style=\"text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($total2);
echo "                    </td>\n                </tr>\n                <tr>\n                    <td>\n                        PENGHASILAN BENGKEL<br>\n                        TOTAL 1 + TOTAL 2\n                    </td>\n                    <td style=\"text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($total1 + $total2);
echo "                    </td>\n                </tr>\n            </table>\n        </td>\n    </tr>\n</table>\n\nII. LAPORAN PENDAPATAN PART (PENJUALAN LANGSUNG)\n<table style=\"width: 50%\">\n    <tr>\n        <td>\n            <table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n                ";
$sparePart = app\components\LbbHelper::getTotalEntryPengeluaranPart();
echo "                <tr>\n                    <td style=\"width: 70%\">A. SPARE PARTS</td>\n                    <td style=\"width: 30%;text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($sparePart);
echo "                    </td>\n                </tr>\n                ";
$oli = app\components\LbbHelper::getTotalEntryPengeluaranOli();
echo "                <tr>\n                    <td>B. OLI</td>\n                    <td style=\"text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($oli);
echo "                    </td>\n                </tr>\n                <tr>\n                    <td>TOTAL - 3</td>\n                    <td style=\"text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($sparePart + $oli);
echo "                    </td>\n                </tr>\n            </table>\n        </td>\n    </tr>\n</table>\n\n<br><br>\nIII. JUMLAH UNIT SEPEDA MOTOR YANG DIKERJAKAN\n<table style=\"width: 100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"sepedaMotor\">\n    <tr>\n        <td style=\"text-align: center;width: 3%\" rowspan=\"3\">No</td>\n        <td style=\"text-align: center;width: 10%\" rowspan=\"3\">TIPE</td>\n        <td style=\"text-align: center\" rowspan=\"3\">NAMA</td>\n        <td style=\"text-align: center;width: 5%\" rowspan=\"3\">JML UNIT ENTRY</td>\n        <td style=\"text-align: center\" colspan=\"12\">YANG DIKERJAKAN DARI UNIT INI</td>\n    </tr>\n    <tr>\n        <td style=\"text-align: center\" colspan=\"4\">KARTU PERAWATAN BERKALA</td>\n        <td style=\"text-align: center;width: 5%\" rowspan=\"2\">CLAIM</td>\n        <td style=\"text-align: center\" colspan=\"3\">QUICK SERVICE</td>\n        <td style=\"text-align: center;width: 5%\" rowspan=\"2\">LR</td>\n        <td style=\"text-align: center;width: 5%\" rowspan=\"2\">HR</td>\n        <td style=\"text-align: center;width: 5%\" rowspan=\"2\">JR</td>\n        <td style=\"text-align: center;width: 5%\" rowspan=\"2\">TOTAL</td>\n    </tr>\n    <tr>\n        <td style=\"text-align: center;width: 5%\">1</td>\n        <td style=\"text-align: center;width: 5%\">2</td>\n        <td style=\"text-align: center;width: 5%\">3</td>\n        <td style=\"text-align: center;width: 5%\">4</td>\n        <td style=\"text-align: center;width: 5%\">CS</td>\n        <td style=\"text-align: center;width: 5%\">LS</td>\n        <td style=\"text-align: center;width: 5%\">G.OLI</td>\n    </tr>\n\n    ";
$dataMotors = array();
$grandTotal = array("ass1" => 0, "ass2" => 0, "ass3" => 0, "ass4" => 0, "claim" => 0, "cs" => 0, "ls" => 0, "go" => 0, "lr" => 0, "hr" => 0, "jr" => 0, "total" => 0, "unit_entry" => 0);
$tahun = array();
$maxYear = date("Y");
$minYear = $maxYear - 11;
for ($i = $minYear; $i <= $maxYear; $i++) {
    $tahun[$i] = 0;
}
$tahun["other"] = 0;
$perintahKerjas = app\models\PerintahKerja::find()->where(array("perintah_kerja.jaringan_id" => app\models\Jaringan::getCurrentID()))->andWhere("waktu_daftar between '" . $_GET["tanggal1"] . " 00:00:00' AND '" . $_GET["tanggal2"] . " 23:59:59'")->all();
foreach ($perintahKerjas as $perintahKerja) {
    $konsumen = $perintahKerja->konsumen;
    if ($konsumen->tahun_rakit != NULL) {
        if (isset($tahun[$konsumen->tahun_rakit])) {
            $tahun[$konsumen->tahun_rakit] += 1;
        } else {
            $tahun["other"] += 1;
        }
    } else {
        $tahun["other"] += 1;
    }
    $motor = $konsumen->motor;
    if (isset($motor)) {
        if (!isset($dataMotors[$motor->id])) {
            $dataMotors[$motor->id] = array("id" => $motor->id, "group" => $motor->motorGroup->nama, "data" => array("kode" => $motor->kode, "nama" => $motor->nama, "ass1" => 0, "ass2" => 0, "ass3" => 0, "ass4" => 0, "claim" => 0, "cs" => 0, "ls" => 0, "go" => 0, "lr" => 0, "hr" => 0, "jr" => 0, "total" => 0, "unit_entry" => 0));
        }
        $dataMotors[$motor->id]["data"]["unit_entry"] += 1;
        foreach ($perintahKerja->notaJasas as $notaJasa) {
            foreach ($notaJasa->notaJasaDetails as $detail) {
                $jasa = $detail->jasa;
                if ($jasa->jasa_group_id == app\models\JasaGroup::ASS1) {
                    $dataMotors[$motor->id]["data"]["ass1"] += 1;
                } else {
                    if ($jasa->jasa_group_id == app\models\JasaGroup::ASS2) {
                        $dataMotors[$motor->id]["data"]["ass2"] += 1;
                    } else {
                        if ($jasa->jasa_group_id == app\models\JasaGroup::ASS3) {
                            $dataMotors[$motor->id]["data"]["ass3"] += 1;
                        } else {
                            if ($jasa->jasa_group_id == app\models\JasaGroup::ASS4) {
                                $dataMotors[$motor->id]["data"]["ass4"] += 1;
                            } else {
                                if ($jasa->jasa_group_id == app\models\JasaGroup::CL) {
                                    $dataMotors[$motor->id]["data"]["claim"] += 1;
                                } else {
                                    if ($jasa->jasa_group_id == app\models\JasaGroup::PL) {
                                        $dataMotors[$motor->id]["data"]["cs"] += 1;
                                    } else {
                                        if ($jasa->jasa_group_id == app\models\JasaGroup::PR) {
                                            $dataMotors[$motor->id]["data"]["ls"] += 1;
                                        } else {
                                            if ($jasa->jasa_group_id == app\models\JasaGroup::GO) {
                                                $dataMotors[$motor->id]["data"]["go"] += 1;
                                            } else {
                                                if ($jasa->jasa_group_id == app\models\JasaGroup::LR) {
                                                    $dataMotors[$motor->id]["data"]["lr"] += 1;
                                                } else {
                                                    if ($jasa->jasa_group_id == app\models\JasaGroup::HR) {
                                                        $dataMotors[$motor->id]["data"]["hr"] += 1;
                                                    } else {
                                                        if ($jasa->jasa_group_id == app\models\JasaGroup::JR) {
                                                            $dataMotors[$motor->id]["data"]["jr"] += 1;
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
                $dataMotors[$motor->id]["data"]["total"] += 1;
            }
        }
    }
}
$motorResult = array_values($dataMotors);
$groupedResult = yii\helpers\ArrayHelper::map($motorResult, "id", "data", "group");
foreach ($groupedResult as $kodeGroup => $arrayMotor) {
    echo "        <tr>\n            <td colspan=\"16\" style=\"border: 0px;font-weight: bold;padding: 10px\">";
    echo $kodeGroup;
    echo "</td>\n        </tr>\n        ";
    $subTotal = array("ass1" => 0, "ass2" => 0, "ass3" => 0, "ass4" => 0, "claim" => 0, "cs" => 0, "ls" => 0, "go" => 0, "lr" => 0, "hr" => 0, "jr" => 0, "total" => 0, "unit_entry" => 0);
    $no = 1;
    foreach ($arrayMotor as $key => $value) {
        echo "            <tr>\n                <td>";
        echo $no++;
        echo "</td>\n                <td>";
        echo $value["kode"];
        echo "</td>\n                <td>";
        echo $value["nama"];
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["unit_entry"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["ass1"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["ass2"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["ass3"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["ass4"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["claim"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["cs"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["ls"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["go"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["lr"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["hr"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["jr"], false);
        echo "</td>\n                <td style=\"text-align: right\">";
        echo app\components\Angka::toReadableAngka($value["total"], false);
        echo "</td>\n            </tr>\n            ";
        foreach ($subTotal as $key => $v) {
            $subTotal[$key] += $value[$key];
        }
    }
    echo "        <tr>\n            <td colspan=\"3\">SUB TOTAL</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["unit_entry"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["ass1"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["ass2"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["ass3"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["ass4"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["claim"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["cs"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["ls"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["go"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["lr"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["hr"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["jr"], false);
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($subTotal["total"], false);
    echo "</td>\n        </tr>\n        ";
    foreach ($grandTotal as $key => $v) {
        $grandTotal[$key] += $subTotal[$key];
    }
}
echo "    <tr>\n        <td colspan=\"16\" style=\"border: 0px;font-weight: bold;padding: 5px\">&nbsp;</td>\n    </tr>\n    <tr>\n        <td colspan=\"3\">TOTAL</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["unit_entry"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["ass1"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["ass2"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["ass3"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["ass4"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["claim"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["cs"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["ls"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["go"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["lr"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["hr"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["jr"], false);
echo "</td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($grandTotal["total"], false);
echo "</td>\n    </tr>\n</table>\n<br>\n<br>\n";
$totalSepeda = 0;
echo "<table style=\"width: 100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n    <tr>\n        <td style=\"text-align: center\">TAHUN KENDARAAN</td>\n        <td style=\"text-align: center;width: 10%\">Lain-lain</td>\n        ";
foreach ($tahun as $key => $value) {
    if ($key == "other") {
        continue;
    }
    echo "            <td style=\"text-align: center;width: 5%\">";
    echo $key;
    echo "</td>\n        ";
}
echo "        <td style=\"text-align: center;width: 5%\">TOTAL</td>\n    </tr>\n    <tr>\n        <td style=\"text-align: center\">JUMLAH UNIT</td>\n        <td style=\"text-align: center\">";
echo $tahun["other"];
echo "</td>\n        ";
foreach ($tahun as $key => $value) {
    $totalSepeda += $value;
    if ($key == "other") {
        continue;
    }
    echo "            <td style=\"text-align: center\">";
    echo $value;
    echo "</td>\n        ";
}
echo "        <td style=\"text-align: center\">";
echo $totalSepeda;
echo "</td>\n    </tr>\n</table>";

?>