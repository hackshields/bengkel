<?php

app\components\WppHelper::setDate($_GET["tanggal1"], $_GET["tanggal2"]);
echo "<html>\n<body>\n<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n</style>\n\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 4%\">No</td>\n        <td style=\"width: 30%\">Parameter</td>\n        <td style=\"width: 30%\">Penjelasan</td>\n        <td style=\"width: 18%\">Rumus</td>\n        <td style=\"width: 18%\">Hasil</td>\n    </tr>\n    ";
$totalJasa = app\components\WppHelper::getTotalJasa();
$mekanikProduktif = app\components\WppHelper::getJumlahMekanikProduktif();
echo "    <tr>\n        <td>1</td>\n        <td>Produktifitas Per Mekanik</td>\n        <td>\n            ";
echo divider("Pendapatan Jasa Service Bln Ini", "Jumlah Mekanik Produktif");
echo "        </td>\n        <td>\n            ";
echo divider(app\components\Angka::toReadableHarga($totalJasa), $mekanikProduktif . " Mekanik");
echo "        </td>\n        <td style=\"text-align: right\">Rp ";
echo safecalculator($totalJasa, $mekanikProduktif, false);
echo "</td>\n    </tr>\n    ";
$jamTerpakai = app\components\WppHelper::getJumlahJamTerpakaiMekanik();
$jamTersedia = app\components\WppHelper::getJumlahJamTersediaMekanik();
echo "    <tr>\n        <td>2</td>\n        <td>Efisiensi</td>\n        <td>\n            ";
echo divider("Jml Jam yg Terpakai Bln Ini", "Jml Jam yg Tersedia Bln Ini");
echo "        </td>\n        <td>\n            ";
echo divider($jamTerpakai . " Jam", $jamTersedia . " Jam");
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($jamTerpakai, $jamTersedia, true);
echo " %</td>\n    </tr>\n    ";
$jmlDiulang = app\components\WppHelper::getJumlahPekerjaanDiulang();
$jmlNonDiulang = app\components\WppHelper::getJumlahPekerjaanTotal() - $jmlDiulang;
echo "    <tr>\n        <td>3</td>\n        <td>Pekerjaan Ulang</td>\n        <td>\n            ";
echo divider("Jml Pekerjaan yg Diulang", "Jml Unit Dikerjakan tdk Trmsk yg Diulang");
echo "        </td>\n        <td>\n            ";
echo divider($jmlDiulang . " Unit", $jmlNonDiulang . " Unit");
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($jmlDiulang, $jmlNonDiulang, true);
echo " %</td>\n    </tr>\n    ";
$jumlahHariAbsenMekanik = app\components\WppHelper::getJumlahHariAbsenMekanik();
$jumlahHariKerja = app\components\WppHelper::getJumlahHariAktif() * $mekanikProduktif;
echo "    <tr>\n        <td>4</td>\n        <td>Absensi Mekanik</td>\n        <td>\n            ";
echo divider("Hari Absen Mekanik Bln Ini", "Jml Hr Kerja X Jml Mekanik");
echo "        </td>\n        <td>\n            ";
echo divider($jumlahHariAbsenMekanik . " Hari", $jumlahHariKerja . " Hari");
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($jumlahHariAbsenMekanik, $jumlahHariKerja, true);
echo " %</td>\n    </tr>\n    ";
$totalPengeluaran = app\components\WppHelper::getTotalPengeluaran();
$totalJasa = app\components\WppHelper::getTotalJasa();
echo "    <tr>\n        <td>5</td>\n        <td>Rasio Biaya Operasi dan Pendapatan</td>\n        <td>\n            ";
echo divider("Biaya Pengeluaran Bengkel Bln Ini", "Pendapatan Jasa Service Bln Ini");
echo "        </td>\n        <td>\n            ";
echo divider(app\components\Angka::toReadableHarga($totalPengeluaran), app\components\Angka::toReadableHarga($totalJasa));
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($totalPengeluaran, $totalJasa, true);
echo " %</td>\n    </tr>\n    ";
$unitDikerjakan = app\components\WppHelper::getJumlahPekerjaanTotal();
echo "    <tr>\n        <td>6</td>\n        <td>Kapasitas Mekanik</td>\n        <td>\n            ";
echo divider("Unit yg Dikerjakan Bln Ini", "Jumlah Mekanik Produktif");
echo "        </td>\n        <td>\n            ";
echo divider($unitDikerjakan . " Unit", $mekanikProduktif . " Mekanik");
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($unitDikerjakan, $mekanikProduktif, true);
echo " %</td>\n    </tr>\n        <tr>\n        <td>7</td>\n        <td>Harga Man Hour</td>\n        <td>\n            ";
echo divider("Pendapatan Jasa Service Bln Ini", "Jumlah Jam yg Terpakai Bln Ini");
echo "        </td>\n        <td>\n            ";
echo divider(app\components\Angka::toReadableHarga($totalJasa), $jamTerpakai . " Jam");
echo "        </td>\n        <td style=\"text-align: right\">Rp ";
echo safecalculator($totalJasa, $jamTerpakai, false);
echo "</td>\n    </tr>\n    ";
$totalPart = app\components\WppHelper::getTotalPart();
$totalJasaDanPart = $totalJasa + $totalPart;
echo "    <tr>\n        <td>8</td>\n        <td>Kesanggupan Menjual</td>\n        <td>\n            ";
echo divider("Pendapatan Jasa + Part Service Bln Ini", "Unit yg Dikerjakan");
echo "        </td>\n        <td>\n            ";
echo divider(app\components\Angka::toReadableHarga($totalJasaDanPart), $unitDikerjakan . " Unit");
echo "        </td>\n        <td style=\"text-align: right\">Rp ";
echo safecalculator($totalJasaDanPart, $unitDikerjakan, false);
echo "</td>\n    </tr>\n        <tr>\n        <td>9</td>\n        <td>Rasio Pendapatan & Penjualan Spare Part</td>\n        <td>\n            ";
echo divider("Pendapatan Jasa Service Bln Ini", "Pendapatan Sparepart Service Bln Ini");
echo "        </td>\n        <td>\n            ";
echo divider(app\components\Angka::toReadableHarga($totalJasa), app\components\Angka::toReadableHarga($totalPart));
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($totalJasa, $totalPart, true);
echo " %</td>\n    </tr>\n    ";
$jumlahPelanggan = app\components\WppHelper::getJumlahPelanggan();
echo "    <tr>\n        <td>10</td>\n        <td>Rasio Langgan Baru</td>\n        <td>\n            ";
echo divider("Jml Pelanggan Baru Bln Ini", "Jml Pelanggan Dalam Bln Ini");
echo "        </td>\n        <td>\n            ";
echo divider($jumlahPelanggan["baru"] . " Unit", $jumlahPelanggan["total"] . " Unit");
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($jumlahPelanggan["baru"], $jumlahPelanggan["total"], true);
echo " %</td>\n    </tr>\n    ";
$jumlahPelangganTerkontrol = app\components\WppHelper::getJumlahPelangganTerkontrol();
echo "    <tr>\n        <td>11</td>\n        <td>Efektifitas Penanganan Langganan Baru</td>\n        <td>\n            ";
echo divider("Jml Pelanggan Baru Bln Ini", "Jml Pelanggan yg Terkontrol");
echo "        </td>\n        <td>\n            ";
echo divider($jumlahPelanggan["baru"] . " Unit", $jumlahPelangganTerkontrol . " Unit");
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($jumlahPelanggan["baru"], $jumlahPelangganTerkontrol, true);
echo " %</td>\n    </tr>\n    ";
$jumlahPelanggan2Tahun = app\components\WppHelper::getJumlahPelanggan2TahunKeBelakang();
echo "    <tr>\n        <td>12</td>\n        <td>Efektifitas Penanganan Langganan</td>\n        <td>\n            ";
echo divider("Jml Pelanggan yg Terkontrol", "Jml Pelanggan Selama 2 Th");
echo "        </td>\n        <td>\n            ";
echo divider($jumlahPelangganTerkontrol . " Unit", $jumlahPelanggan2Tahun . " Unit");
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($jumlahPelangganTerkontrol, $jumlahPelanggan2Tahun, true);
echo " %</td>\n    </tr>\n    ";
$jumlahPartTidakTersedia = app\components\WppHelper::getTotalPartTidakTersedia();
$jumlahPenjualanPart = app\components\WppHelper::getTotalPenjualanPart();
echo "    <tr>\n        <td>13</td>\n        <td>Rasio Spare Parts Tidak Tersedia</td>\n        <td>\n            ";
echo divider("Jml Part yg tdk Tersedia Bln Ini", "Jml Penjualan Part");
echo "        </td>\n        <td>\n            ";
echo divider($jumlahPartTidakTersedia . " Rp", $jumlahPenjualanPart . " Rp");
echo "        </td>\n        <td style=\"text-align: right\">";
echo safecalculator($jumlahPartTidakTersedia, $jumlahPenjualanPart, true);
echo " %</td>\n    </tr>\n        <tr>\n        <td>14</td>\n        <td>Total Pendapatan Jasa</td>\n        <td>\n            Total Pendapatan Jasa\n        </td>\n        <td>\n            Rupiah\n        </td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($totalJasa);
echo "</td>\n    </tr>\n        <tr>\n        <td>15</td>\n        <td>Total Pendapatan Part</td>\n        <td>\n            Total Pendapatan Sparepart\n        </td>\n        <td>\n            Rupiah\n        </td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableHarga($jumlahPenjualanPart);
echo "</td>\n    </tr>\n    ";
$totalEntryKPB = app\components\WppHelper::getTotalEntryKPB();
echo "    <tr>\n        <td>16</td>\n        <td>Total Unit Entry KPB</td>\n        <td>\n            Total Unit Entry KPB\n        </td>\n        <td>\n            Unit\n        </td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalEntryKPB);
echo "</td>\n    </tr>\n    ";
$totalEntryNonKPB = $jumlahPelanggan["total"] - $totalEntryKPB;
echo "    <tr>\n        <td>17</td>\n        <td>Total Unit Entry Non KPB</td>\n        <td>\n            Total Unit Entry Non KPB\n        </td>\n        <td>\n            Unit\n        </td>\n        <td style=\"text-align: right\">";
echo app\components\Angka::toReadableAngka($totalEntryNonKPB);
echo "</td>\n    </tr>\n        <tr>\n        <td>18</td>\n        <td>\n            Data History Card\n            <br>\n            <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%\">\n                <tr>\n                    <td>Langganan Lama</td>\n                    <td>Langganan Baru</td>\n                </tr>\n                <tr>\n                    <td colspan=\"2\">Jumlah Pelanggan Bulan Ini</td>\n                </tr>\n            </table>\n            <br>\n            <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%\">\n                <tr>\n                    <td>Pelanggan Terkontrol</td>\n                </tr>\n                <tr>\n                    <td>Total Pelanggan dalam 3 Tahun</td>\n                </tr>\n            </table>\n        </td>\n        <td colspan=\"3\" style=\"text-align: center\">\n            <br>\n            <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 300px\">\n                <tr>\n                    <td>";
echo $jumlahPelanggan["lama"];
echo "</td>\n                    <td>";
echo $jumlahPelanggan["baru"];
echo "</td>\n                </tr>\n                <tr>\n                    <td colspan=\"2\">";
echo $jumlahPelanggan["total"];
echo "</td>\n                </tr>\n            </table>\n            <br>\n            <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 300px\">\n                <tr>\n                    <td>";
echo $jumlahPelangganTerkontrol;
echo "</td>\n                </tr>\n                <tr>\n                    <td>";
echo $jumlahPelanggan2Tahun;
echo "</td>\n                </tr>\n            </table>\n        </td>\n    </tr>\n</table>\n\n<br><br><br>\n\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 25%;border-bottom: 1px solid #000\">\n            Dibuat,\n            <br>\n            <br>\n            <br>\n            <br>\n        </td>\n        <td style=\"width: 12.5%\">\n\n        </td>\n        <td style=\"width: 25%;border-bottom: 1px solid #000\">\n            Diperiksa,\n            <br>\n            <br>\n            <br>\n            <br>\n        </td>\n        <td style=\"width: 12.5%\">\n\n        </td>\n        <td style=\"width: 25%;border-bottom: 1px solid #000\">\n            Mengetahui,\n            <br>\n            <br>\n            <br>\n            <br>\n        </td>\n    </tr>\n</table>\n</body>\n</html>\n";
function divider($top, $under)
{
    return "<table>\n<tr>\n<td style='border-bottom: 2px solid #000;'>" . $top . "</td>\n</tr>\n<tr>\n<td>" . $under . "</td>\n</tr>\n</table>";
}
function safeCalculator($num1, $num2, $asPercent = false)
{
    if ($num1 == 0 && $num2 == 0) {
        return $asPercent ? "0,00" : "0";
    }
    if ($num2 == 0) {
        return $asPercent ? "0,00" : "0";
    }
    $hasil = $num1 / $num2;
    if ($asPercent) {
        return number_format($hasil * 100, 2, ",", ".");
    }
    return number_format($hasil, 0, ",", ".");
}

?>