<?php

$model = new app\models\SukuCadangJaringan();
$user = Yii::$app->user->identity;
echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'north'\" style=\"height:50%;overflow: hidden\">\n        <table class=\"easyui-datagrid\" id=\"list_all_suku_cadang\" style=\"height: 100%\">\n            <thead>\n            <tr>\n                <th field=\"kode\" width=\"120\">Kode Part</th>\n                <th field=\"nama\" width=\"220\">Nama</th>\n                <th field=\"nama_sinonim\" width=\"220\">Sinonim</th>\n                <th field=\"het\" width=\"80\" align=\"right\" formatter=\"formatMoney\">HET</th>\n                <th field=\"harga_jual\" width=\"80\" align=\"right\" formatter=\"formatMoney\">Harga Jual</th>\n                <th field=\"quantity\" width=\"80\" align=\"right\">Quantity</th>\n                <th field=\"opname_terakhir\" width=\"120\" align=\"center\">Opname Terakhir</th>\n            </tr>\n            </thead>\n        </table>\n    </div>\n    <div data-options=\"region:'center'\" style=\"height:40%;padding: 10px 20px\">\n        <form id=\"form\" method=\"post\" action=\"\">\n            <div class=\"half\">\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::combo($model, "gudang_id", 300, yii\helpers\ArrayHelper::map(app\models\Gudang::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->all(), "id", "nama"), array("prompt" => "(Pilih)"));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::combo($model, "rak_id", 300, yii\helpers\ArrayHelper::map(app\models\Rak::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->all(), "id", "nama"), array("prompt" => "(Pilih)"));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "harga_beli", 250);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "harga_jual", 250);
echo "                </div>\n\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "hpp", 250, true, array("disabled" => true));
echo "                </div>\n            </div>\n            <div class=\"half\">\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "quantity", 250, false, array("disabled" => true));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "quantity_booking", 250, false, array("disabled" => true));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "quantity_max", 250, false);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "quantity_min", 250, false);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::combo($model, "promo_id", 300, yii\helpers\ArrayHelper::map(app\models\Promo::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->all(), "id", "nama"), array("prompt" => "(Pilih)"));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::date($model, "opname_terakhir", 250, array("disabled" => true));
echo "                </div>\n            </div>\n        </form>\n    </div>\n    <div data-options=\"region:'south'\" style=\"height:10%;padding: 10px 20px\">\n        <!-- <button id=\"btn-add\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-add'\">Tambah Baru</button> -->\n        <button id=\"btn-save\" class=\"easyui-linkbutton\" data-options=\"iconCls:'fam disk'\">Simpan</button>\n        <button id=\"btn-delete\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-cancel'\">Hapus</button>\n    </div>\n</div>\n\n<script>\n    var sukuCadang = null;\n    \$(\"#list_all_suku_cadang\").datagrid({\n        url: \"";
echo yii\helpers\Url::to(array("list-data"));
echo "\",\n        toolbar: addSearchToolbar(\"list_all_suku_cadang\"),\n        singleSelect: true,\n        pagination: true,\n        rownumbers: true,\n        onClickRow: function (index, row) {\n            sukuCadang = row;\n\n            \$.ajax({\n                url : \"";
echo yii\helpers\Url::to(array("load"));
echo "?id=\" + sukuCadang.id,\n                dataType : \"json\",\n                success: function(data){\n                    for (var property in sukuCadang) {\n                        if (sukuCadang.hasOwnProperty(property)) {\n                            console.log(property, sukuCadang[property])\n                            \$(\"#\" + property).setValue(sukuCadang[property]);\n                        }\n                    }\n                }\n            });\n        }\n    });\n\n    \$(\"#btn-add\").linkbutton({\n        onClick: function () {\n            \$(\"#form\").form('reset');\n            sukuCadang = null;\n        }\n    });\n\n    \$(\"#btn-save\").linkbutton({\n        onClick: function () {\n            var serialize = \$(\"#form\").serialize();\n            console.log(serialize);\n            \$.ajax({\n                url: \"";
echo yii\helpers\Url::to(array("save"));
echo "\" + (sukuCadang == null ? \"\" : \"?id=\" + sukuCadang.id),\n                data: serialize,\n                type: \"post\",\n                dataType: \"json\",\n                success: function (msg) {\n                    if(msg.status == 200) {\n                        dialog(\"Simpan Data Sukses\");\n                        \$('#tt').datagrid('reload');\n                    }\n                },\n                error: function(xhr, ajaxOptions, thrownError){\n                    dialog(xhr.responseJSON.message);\n                }\n            });\n            return false;\n        }\n    });\n\n    \$(\"#btn-delete\").click(function () {\n        \$.ajax({\n            url: \"";
echo yii\helpers\Url::to(array("delete"));
echo "?id=\" + sukuCadang.id,\n            success: function (msg) {\n                dialog(\"Hapus Data Sukses\");\n                \$('#tt').datagrid('reload');\n                \$(\"#form\").form(\"clear\");\n                sukuCadang = null;\n            }\n        });\n        return false;\n    });\n\n    setTitle(\"Suku Cadang\");\n</script>";

?>