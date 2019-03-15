<?php

$user = app\models\User::find()->where(array("id" => $_GET["karyawan_id"]))->one();
$tanggal = strtotime($_GET["tanggal1"]);
$tanggal2 = strtotime($_GET["tanggal2"]);
$no = 1;
$arrHari = array("Sunday" => "Minggu", "Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis", "Friday" => "Jumat", "Saturday" => "Sabtu");
echo "<html>\n<head>\n    <style>\n        body {\n            font-family: \"Courier New\", Courier, monospace;\n            font-size: 12px;\n        }\n\n        td {\n            padding-left: 5px;\n            padding-right: 5px;\n            font-size: 11px;\n        }\n    </style>\n</head>\n<body>\n    Karyawan : ";
echo $user->kode;
echo " - ";
echo $user->name;
echo "<table style=\"width: 100%\">\n    <tr>\n        <td>No</td>\n        <td>Tanggal</td>\n        <td>Hari</td>\n        <td>Datang</td>\n        <td>Pulang</td>\n        <td>Status</td>\n        <td>Keterangan</td>\n    </tr>\n    ";
$i = $tanggal;
while ($i <= $tanggal2) {
    $absen = app\models\Absensi::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID(), "karyawan_id" => $user->id, "date(jam_masuk)" => date("d-m-Y", $i)))->one();
    echo "    <tr>\n        <td>";
    echo $no++;
    echo "</td>\n        <td>";
    echo date("d-m-Y", $i);
    echo "</td>\n        <td>";
    echo $arrHari[date("l", $i)];
    echo "</td>\n        <td>";
    echo $absen ? date("H:i", strtotime($absen->jam_masuk)) : "-";
    echo "</td>\n        <td>";
    echo $absen->jam_pulang ? date("H:i", strtotime($absen->jam_pulang)) : "-";
    echo "</td>\n        <td>";
    echo $absen->absensiStatus->nama;
    echo "</td>\n        <td>";
    echo $absen->keterangan;
    echo "</td>\n    </tr>\n    ";
    $i += 3600 * 24;
}
echo "</table>\n</body>\n</html>\n";

?>