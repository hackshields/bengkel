<?php

echo "<html>\n<body>\n<style>\n    body {\n        font-family: \"Courier New\", Courier, monospace;\n        font-size: 12px;\n    }\n\n    td {\n        padding-left: 5px;\n        padding-right: 5px;\n        font-size: 11px;\n    }\n\n    table.border{\n        /* border-collapse: collapse;\n        border: 1px solid black; */\n        width: 100%;\n    }\n    table.border td{\n        /* border: 1px solid black; */\n        padding: 5px 10px;\n    }\n</style>\n<table style=\"width: 100%\">\n    <tr>\n        <td style=\"width: 35%;vertical-align: top\">\n            Dokumen :\n            <br>\n            ";
echo $model->nomor;
echo "        </td>\n        <td style=\"width: 30%;text-align: right;vertical-align: top\">\n            KEPADA YTH :\n        </td>\n        <td style=\"width: 35%;vertical-align: top\">\n            ";
echo $model->supplier->kode;
echo "            <br>\n            ";
echo $model->supplier->nama;
echo "            <br>\n            ";
echo $model->supplier->alamat;
echo "            <hr>\n            UP :\n        </td>\n    </tr>\n</table>\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 20px 0\" class=\"border\">\n    <tr>\n        <td>NO.</td>\n        <td>KODE PART</td>\n        <td>DESKRIPSI</td>\n        <td style=\"text-align: right\">JUMLAH ORDER</td>\n    </tr>\n    ";
$no = 1;
foreach ($model->purchaseOrderDetails as $detail) {
    echo "        <tr>\n            <td>";
    echo $no++;
    echo "</td>\n            <td>";
    echo $detail->sukuCadang->kode;
    echo "</td>\n            <td>";
    echo $detail->sukuCadang->nama;
    echo "</td>\n            <td style=\"text-align: right\">";
    echo app\components\Angka::toReadableAngka($detail->quantity_order, false);
    echo "</td>\n        </tr>\n    ";
}
echo "</table>\n\nDisetujui Oleh,\n<br>\n<br>\n<br>\n<br>\n<br>\n<br>\n( _________________________ )\n</body>\n</html>\n";

?>