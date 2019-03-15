<?php

echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'center'\" title=\"Notifikasi\" style=\"overflow: hidden;padding:20px\">\n        <div style=\"padding-bottom: 10px\">\n            Versi Aplikasi Anda saat ini : ";
echo APP_VERSION;
echo "        </div>\n        <a id=\"download\" href=\"#\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-save'\">Download</a>\n    </div>\n    <div id=\"process_output\" data-options=\"region:'east'\" title=\"Output\" style=\"width:75%;overflow: scroll;padding:20px\">\n\n    </div>\n</div>\n<script>\n    \$(\"#download\").click(function(){\n        \$.ajax({\n            url: \"";
echo yii\helpers\Url::to(array("update-git"));
echo "\",\n            dataType: \"text\",\n            success : function(msg){\n                \$(\"#process_output\").html(msg);\n\n                processMigration();\n            }\n        });\n        return false;\n    });\n\n    function processMigration(){\n        \$.ajax({\n            url: \"";
echo yii\helpers\Url::to(array("migration"));
echo "\",\n            dataType: \"text\",\n            success : function(msg){\n                \$(\"#process_output\").html(\$(\"#process_output\").html()+\"<br>\"+msg);\n\n                setTimeout(function(){\n                    window.location.reload();\n                }, 2000);\n            }\n        });\n    }\n\n    setTitle(\"Update Aplikasi\");\n</script>";

?>