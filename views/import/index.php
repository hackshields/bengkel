<?php

echo "<div style=\"margin: 100px auto;text-align: center\">\n    <a href=\"";
echo yii\helpers\Url::to(array("upload"));
echo "\" target=\"_blank\" class=\"easyui-linkbutton\"\n       data-options=\"iconCls:'icon-excel_imports-large',size:'large',iconAlign:'top'\">\n        Klik Di Sini untuk melakukan Import\n    </a>\n</div>\n<script>\n    setTitle(\"Import Data\");\n</script>";

?>