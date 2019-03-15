<?php

echo "<html>\n<body>\n<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n\n    table.border{\n        border-collapse: collapse;\n        border: 1px solid black;\n        width: 100%;\n    }\n    table.border td{\n        border: 1px solid black;\n        padding: 5px 10px;\n    }\n</style>\n<table>\n    <tr>\n        <td>\n            No Stock Opname\n        </td>\n        <td>\n            : ";
echo $model->no_opname;
echo "        </td>\n    </tr>\n    <tr>\n        <td>\n            Tanggal\n        </td>\n        <td>\n            : ";
echo app\components\Tanggal::toReadableDate($model->tanggal_opname);
echo "        </td>\n    </tr>\n    <tr>\n        <td>\n            Petugas\n        </td>\n        <td>\n            : ";
echo $model->petugas->name;
echo "        </td>\n    </tr>\n</table>\n<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 20px 0\" class=\"border\">\n    <tr>\n        <td>NO.</td>\n        <td>LOKASI</td>\n        <td>KODE</td>\n        <td>SUKU CADANG</td>\n        <td style=\"text-align: right\">JUMLAH</td>\n        <td>KETERANGAN</td>\n    </tr>\n    ";
$no = 1;
foreach ($model->stockOpnameDetails as $detail) {
    echo "        <tr>\n            <td>";
    echo $no++;
    echo "</td>\n            <td>";
    echo $detail->rak->nama;
    echo "</td>\n            <td>";
    echo $detail->sukuCadang->kode;
    echo "</td>\n            <td>";
    echo $detail->sukuCadang->nama;
    echo "</td>\n            <td>______</td>\n            <td>__________________________</td>\n        </tr>\n    ";
}
echo "</table>\n\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 30%;text-align: center\">\n            Mengetahui,\n            <br>\n            Penanggungjawab\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ( _________________________ )\n        </td>\n        <td style=\"width: 40%;text-align: center\">\n\n        </td>\n        <td style=\"width: 30%;text-align: center\">\n            Petugas Stock Opname,\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            <br>\n            ( _________________________ )\n        </td>\n    </tr>\n</table>\n\n</body>\n</html>\n";

?>