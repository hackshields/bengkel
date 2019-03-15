<?php

echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'center',border:false\" style=\"height:100%;padding: 10px\">\n        <div class=\"form-control\">\n            <a id=\"btn-cetak\" href=\"#\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-search'\">Cetak</a>\n        </div>\n    </div>\n</div>\n<script>\n    \$(\"#btn-cetak\").click(function () {\n        var url = \"";
echo yii\helpers\Url::to(array("stok-akhir"));
echo "\";\n        window.open(url, \"Laporan\", \"width=800,height=600\");\n\n        return false;\n    });\n\n    setTitle(\"Laporan\");\n</script>";

?>