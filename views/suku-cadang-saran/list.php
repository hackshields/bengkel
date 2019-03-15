<?php

$model = new app\models\SukuCadangSaran();
echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'center'\" style=\"height:100%;padding: 10px 20px\">\n        <div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n            <div data-options=\"region:'west',border:false\" style=\"width: 30%\">\n                <form id=\"form_1\" method=\"post\" action=\"\">\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "kode", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "nama", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "nama_sinonim", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "suku_cadang_group_id", 300, yii\helpers\ArrayHelper::map(app\models\SukuCadangGroup::find()->all(), "id", "nama"));
echo "                    </div>\n                </form>\n            </div>\n            <div data-options=\"region:'center',border:false\">\n                <form id=\"form_2\" method=\"post\" action=\"\">\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "merek_id", 300, yii\helpers\ArrayHelper::map(app\models\Merek::find()->all(), "id", "nama"));
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "fs", 300, array("F" => "Fast Moving", "S" => "Slow Moving"));
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "import", 300, array("IMPORT" => "Impor", "LOKAL" => "Lokal"));
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "rank", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "lifetime", 300, array("L" => "Long", "S" => "Short", "O" => "Other"));
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "fungsi", 300, array("A" => "Additional", "I" => "Important", "S" => "Safety", "O" => "Other"));
echo "                    </div>\n                </form>\n            </div>\n            <div data-options=\"region:'east',border:false\" style=\"width: 40%\">\n                <form id=\"form_3\" method=\"post\" action=\"\">\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "dimensi_panjang", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "dimensi_lebar", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "dimensi_tinggi", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "dimensi_berat", 300);
echo "                    </div>\n                </form>\n            </div>\n        </div>\n    </div>\n    <div data-options=\"region:'south'\" style=\"height:10%;padding: 10px 20px\">\n        <button id=\"btn-add\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-add'\">Reset</button>\n        <a href=\"javascript:void(0)\" id=\"btn-save\" class=\"easyui-linkbutton\"\n           data-options=\"iconCls:'fam disk'\">Ajukan Nama Sparepart</a>\n    </div>\n</div>\n\n<script>\n    var sukuCadang = null;\n\n\n    \$(\"#btn-add\").linkbutton({\n        onClick: function () {\n            \$(\"#form_1\").form('reset');\n            \$(\"#form_2\").form('reset');\n            \$(\"#form_3\").form('reset');\n            sukuCadang = null;\n        }\n    });\n\n    \$(\"#btn-save\").linkbutton({\n        onClick: function () {\n            var serialize = \$(\"#form_1\").serialize() + \"&\" + \$(\"#form_2\").serialize() + \"&\" + \$(\"#form_3\").serialize();\n            console.log(serialize);\n            \$.ajax({\n                url: \"";
echo yii\helpers\Url::to(array("save"));
echo "\" + (sukuCadang == null ? \"\" : \"?id=\" + sukuCadang.id),\n                data: serialize,\n                type: \"post\",\n                dataType: \"json\",\n                success: function (msg) {\n                    if (msg.status == 200) {\n                        dialog(\"Pengajuan nama suku cadang sukses. Kami akan mengupdate data secepatnya.\");\n                        \$('#tt').datagrid('reload');\n\n                        \$(\"#form_1\").form('reset');\n                        \$(\"#form_2\").form('reset');\n                        \$(\"#form_3\").form('reset');\n                    }\n                },\n                error: function (xhr, ajaxOptions, thrownError) {\n                    dialog(xhr.responseJSON.message);\n                }\n            });\n            return false;\n        }\n    });\n\n    setTitle(\"Pengajuan Nama Suku Cadang\");\n</script>";

?>