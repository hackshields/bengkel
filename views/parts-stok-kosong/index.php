<?php

echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'center',border:false\" style=\"\">\n        <table id=\"list_stok\" style=\"height: 100%;width: 100%;\">\n            <thead>\n            <tr>\n                <th field=\"kode\" width=\"80\">Kode Part</th>\n                <th field=\"nama\" width=\"250\">Nama</th>\n                <th field=\"nama_sinonim\" width=\"250\">Sinonim</th>\n                <th field=\"jumlah\" width=\"100\" align=\"right\">Jumlah yg Dibutuhkan</th>\n            </tr>\n            </thead>\n        </table>\n    </div>\n</div>\n<script>\n    \$(\"#list_stok\").datagrid({\n        url: \"";
echo yii\helpers\Url::to(array("list"));
echo "\",\n        singleSelect: true,\n        pagination: true,\n        rownumbers: true,\n        fitColumns: true,\n        pageSize: 20,\n        toolbar: addSearchToolbar(\"list_stok\")\n    });\n\n    setTitle(\"Stok Kosong\");\n</script>";

?>