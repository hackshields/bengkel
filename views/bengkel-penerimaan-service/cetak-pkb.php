<?php

$noKunjungan = app\models\PerintahKerja::find()->where(array("konsumen_id" => $model->konsumen_id))->andWhere("waktu_daftar < '" . $model->waktu_daftar . "'")->count();
$noKunjungan += 1;
echo "<html>\n<body>\n<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n\n    table.border{\n        border-collapse: collapse;\n        border: 1px solid black;\n        width: 100%;\n    }\n    table.border td{\n        border: 1px solid black;\n        padding: 5px 10px;\n    }\n    td.padleft {\n        padding-left: 10px;\n    }\n    td.bottomBorder {\n        border-bottom: 1px solid #000000;\n    }\n    td.bottomTop {\n        border-top: 1px solid #000000;\n    }\n</style>\n<table style=\"width: 100%\">\n    <tr>\n        <td>No. PKB</td>\n        <td>: ";
echo $model->nomor;
echo "</td>\n        <td class=\"padleft\">Nama STNK</td>\n        <td>: ";
echo $model->konsumen->nama_identitas;
echo "</td>\n        <td class=\"padleft\">No. Polisi</td>\n        <td>: ";
echo $model->konsumen->nopol;
echo "</td>\n    </tr>\n    <tr>\n        <td>No. Urut</td>\n        <td>: ";
echo $model->no_antrian;
echo "</td>\n        <td class=\"padleft\">Pengguna</td>\n        <td>: ";
echo $model->konsumen->nama_pengguna;
echo "</td>\n        <td class=\"padleft\">Tipe Motor</td>\n        <td>: ";
$motor = $model->konsumen->motor;
if ($motor) {
    echo $motor->getNamaLengkap();
} else {
    echo "(No Data)";
}
echo "</td>\n    </tr>\n    <tr>\n        <td>Tanggal</td>\n        <td>: ";
echo app\components\Tanggal::toReadableDate($model->waktu_daftar, false, true);
echo "</td>\n        <td class=\"padleft\">No Telp</td>\n        <td>: ";
echo $model->konsumen->no_telepon;
echo "</td>\n        <td class=\"padleft\">KM</td>\n        <td>: ";
echo $model->km;
echo "</td>\n    </tr>\n</table>\n<br>\n<span style=\"border-bottom: 1px solid #777;padding-bottom: 5px\">Kondisi Awal Motor :</span>\n<br>\n<div style=\"color: #444;font-style: italic;padding: 10px 0px\">\n    ";
echo $model->kondisi_awal;
echo "</div>\n<hr>\n<br>\n\n<span style=\"border-bottom: 1px solid #777;padding-bottom: 5px\">Keluhan Konsumen :</span>\n<br>\n<div style=\"color: #444;font-style: italic;padding: 10px 0px\">\n    ";
echo $model->keluhan;
echo "</div>\n<hr>\n<br>\n\n<span style=\"border-bottom: 1px solid #777;padding-bottom: 5px\">Point Pemeriksaan :</span>\n<br>\n<div style=\"color: #444;font-style: italic;padding: 10px 0px\">\n    ";
echo $model->analisa;
echo "</div>\n<hr>\n<br>\n\n<table style=\"width: 100%\">\n    <tr>\n        <td>\n            ";
$no = 1;
echo "            <table style=\"width: 100%\" >\n                <tr>\n                    <td class=\"bottomBorder\">Jasa Service</td>\n                    <td class=\"bottomBorder\" style=\"text-align: right\">Harga</td>\n                </tr>\n                ";
$totalJasa = 0;
foreach ($model->perintahKerjaJasas as $pkbJasa) {
    echo "                    <tr>\n                        <td>";
    echo $pkbJasa->jasa->nama;
    echo "</td>\n                        <td style=\"text-align: right\">\n                            ";
    echo app\components\Angka::toReadableHarga($pkbJasa->harga);
    echo "                        </td>\n                    </tr>\n                    ";
    $totalJasa += $pkbJasa->harga;
}
echo "                <tr>\n                    <td class=\"bottomTop\">Sub Total Jasa</td>\n                    <td class=\"bottomTop\" style=\"text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($totalJasa);
echo "                    </td>\n                </tr>\n            </table>\n        </td>\n        <td>\n            ";
$no = 1;
echo "            <table style=\"width: 100%\" >\n                <tr>\n                    <td class=\"bottomBorder\">Suku Cadang</td>\n                    <td class=\"bottomBorder\" style=\"text-align: center\">Qty</td>\n                    <td class=\"bottomBorder\" style=\"text-align: right\">Harga</td>\n                </tr>\n                ";
$totalSukuCadang = 0;
foreach ($model->perintahKerjaSukuCadangs as $pkbPart) {
    echo "                    <tr>\n                        <td>";
    echo $pkbPart->sukuCadang->nama;
    echo "</td>\n                        <td style=\"text-align: center\">";
    echo $pkbPart->quantity;
    echo "</td>\n                        <td style=\"text-align: right\">\n                            ";
    echo app\components\Angka::toReadableHarga($pkbPart->total);
    echo "                        </td>\n                    </tr>\n                    ";
    $totalSukuCadang += $pkbPart->total;
}
echo "                <tr>\n                    <td class=\"bottomTop\" colspan=\"2\">Sub Total Suku Cadang</td>\n                    <td class=\"bottomTop\" style=\"text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($totalSukuCadang);
echo "                    </td>\n                </tr>\n            </table>\n        </td>\n    </tr>\n    <tr>\n        <td></td>\n        <td>\n            <table style=\"width: 100%\" >\n                <tr>\n                    <td>Total Estimasi Biaya :</td>\n                    <td style=\"text-align: right\">\n                        ";
echo app\components\Angka::toReadableHarga($totalJasa + $totalSukuCadang);
echo "                    </td>\n                </tr>\n            </table>\n        </td>\n    </tr>\n</table>\n\n<hr>\n<div style=\"font-size: 12px;\">\n    *) Apabila ada tambahan PEKERJAAN / PENGGANTIAN SUKU CADANG di luar daftar di atas, maka :\n</div>\n<div style=\"text-align: center\">\n    ";
echo yii\helpers\Html::img(array($model->konfirmasi == 1 ? "css/images/ic_checked.png" : "css/images/ic_unchecked.png"), array("style" => "width: 16px"));
echo " Konfirmasi / Telp Dulu\n    &nbsp;&nbsp;&nbsp;&nbsp;\n    ";
echo yii\helpers\Html::img(array($model->konfirmasi == 0 ? "css/images/ic_checked.png" : "css/images/ic_unchecked.png"), array("style" => "width: 16px"));
echo " Langsung Dikerjakan\n</div>\n<br>\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 20%;vertical-align: top;text-align: center\">\n            Konsumen,\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            <u>";
echo $model->konsumen->nama_pengguna;
echo "</u>\n        </td>\n        <td style=\"width: 20%;vertical-align: top;text-align: center\">\n            Final Ins\n            <br>\n            <br>\n            <br>\n            <table style=\"width: 100%\">\n                <tr>\n                    <td style=\"width:50%;border: 1px solid #000;vertical-align: middle;text-align: center;font-size: 40px\">\n                        OK\n                    </td>\n                    <td style=\"border: 1px solid #000\">\n                    </td>\n                </tr>\n            </table>\n            Paraf\n        </td>\n        <td style=\"width: 60%;border: 1px solid #000;vertical-align: top\" rowspan=\"2\">\n            Historikal Service :\n            <table style=\"width: 100%\">\n                ";
define("KONSUMEN_ID", $model->konsumen->id);
$hasil = app\models\NotaJasaDetail::find()->joinWith(array("notaJasa" => function ($qHeader) {
    $qHeader->joinWith(array("perintahKerja" => function ($qqHeader) {
        $qqHeader->where(array("perintah_kerja.konsumen_id" => KONSUMEN_ID));
    }));
    $qHeader->andWhere(array("nota_jasa.jaringan_id" => app\models\Jaringan::getCurrentID()));
}))->all();
foreach ($hasil as $item) {
    echo "                <tr>\n                    <td>";
    echo $item->jasa->nama;
    echo "</td>\n                    <td>";
    echo $item->jasa->kode;
    echo "</td>\n                    <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($item->jasa->harga);
    echo "</td>\n                    <td style=\"text-align: center\">";
    echo $item->notaJasa->tanggal_njb;
    echo "</td>\n                </tr>\n                ";
}
echo "            </table>\n        </td>\n    </tr>\n    <tr>\n        <td colspan=\"2\">\n            Kunjungan Ke: ";
echo $noKunjungan;
echo "        </td>\n    </tr>\n</table>\n<hr>\nSaran Mekanik :\n<div style=\"border:1px solid #000;padding: 10px 20px;\">\n    ";
echo $model->catatan;
echo "</div>\n<br>\nSyarat dan Ketentuan : <br>\n- Formulir ini adalah Surat Kuasa Pekerjaan (PKB).<br>\n- Bengkel tidak bertanggung jawab terhadap Motor yang tidak diambil dalam 30 hari.<br>\n- Bengkel tidak bertanggung jawab apabila terjadi force majeur.<br>\n<br>\nGARANSI :<br>\n- Serive Lengkap dan Service Ringan : 500 KM / 1 Minggu **Mana yang lebih dahulu tercapai. <br>\n- Turun Mesin : 1000 KM / 1 Bulan **Mana yang lebih dahulu tercapai.\n\n</body>\n</html>\n";

?>