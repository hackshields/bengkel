<?php

$model = new app\models\Promo();
echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'north'\" style=\"height:50%;overflow: hidden\">\n        <table id=\"tt\"\n               class=\"easyui-datagrid\" style=\"width:100%;height:100%\"\n               url=\"";
echo yii\helpers\Url::to(array("list-data"));
echo "\"\n               title=\"Data Promo\"\n               rownumbers=\"true\" pagination=\"true\">\n            <thead>\n            <tr>\n                <th field=\"nama\" width=\"200\">Nama Promo</th>\n                <th field=\"diskon_p\" width=\"80\" align=\"right\">Diskon (%)</th>\n                <th field=\"diskon_r\" width=\"80\" align=\"right\" formatter=\"formatMoney\">Diskon (Rp)</th>\n                <th field=\"diskon_jasa_p\" width=\"80\" align=\"right\">Diskon Jasa (%)</th>\n                <th field=\"diskon_jasa_r\" width=\"80\" align=\"right\" formatter=\"formatMoney\">Diskon Jasa (Rp)</th>\n                <th field=\"tanggal_awal\" width=\"80\">Tgl. Awal</th>\n                <th field=\"tanggal_akhir\" width=\"80\">Tgl. Akhir</th>\n            </tr>\n            </thead>\n        </table>\n    </div>\n    <div data-options=\"region:'center'\" style=\"height:40%;padding: 10px 20px\">\n        <form id=\"form\" method=\"post\" action=\"\">\n            <div class=\"form-control\">\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "nama", 400);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "diskon_p", 200);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "diskon_r", 200, false);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "diskon_jasa_p", 200);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "diskon_jasa_r", 200, false);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::date($model, "tanggal_awal", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::date($model, "tanggal_akhir", 300);
echo "                </div>\n            </div>\n        </form>\n    </div>\n    <div data-options=\"region:'south'\" style=\"height:10%;padding: 10px 20px\">\n        <button id=\"btn-add\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-add'\">Tambah Baru</button>\n        <button id=\"btn-save\" class=\"easyui-linkbutton\" data-options=\"iconCls:'fam disk'\">Simpan</button>\n        <button id=\"btn-delete\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-cancel'\">Hapus</button>\n    </div>\n</div>\n\n<script>\n    var promo = null;\n\n    \$(\"#tt\").datagrid({\n        toolbar: addSearchToolbar('tt'),\n        onClickRow: function (index, row) {\n            promo = row;\n\n            for (var property in promo) {\n                if (promo.hasOwnProperty(property)) {\n                    //console.log(property, selectedData[property])\n                    \$(\"#\" + property).setValue(promo[property]);\n                }\n            }\n        }\n    });\n\n    \$(\"#btn-add\").linkbutton({\n        onClick: function () {\n            \$(\"#form\").form('reset');\n            promo = null;\n        }\n    });\n\n    \$(\"#btn-save\").linkbutton({\n        onClick: function () {\n            var serialize = \$(\"#form\").serialize();\n            console.log(serialize);\n            \$.ajax({\n                url: \"";
echo yii\helpers\Url::to(array("save"));
echo "\" + (promo == null ? \"\" : \"?id=\" + promo.id),\n                data: serialize,\n                type: \"post\",\n                dataType: \"json\",\n                success: function (msg) {\n                    if(msg.status == 200) {\n                        dialog(\"Simpan Data Sukses\");\n                        \$('#tt').datagrid('reload');\n                    }\n                },\n                error: function(xhr, ajaxOptions, thrownError){\n                    dialog(xhr.responseJSON.message);\n                }\n            });\n            return false;\n        }\n    });\n\n    \$(\"#btn-delete\").click(function () {\n        \$.ajax({\n            url: \"";
echo yii\helpers\Url::to(array("delete"));
echo "?id=\" + promo.id,\n            success: function (msg) {\n                dialog(\"Hapus Data Sukses\");\n                \$('#tt').datagrid('reload');\n                \$(\"#form\").form(\"clear\");\n                promo = null;\n            }\n        });\n        return false;\n    });\n\n    setTitle(\"Promo\");\n</script>";

?>