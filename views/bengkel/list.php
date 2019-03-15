<?php

$model = new app\models\Jaringan();
echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'north'\" style=\"height:50%;overflow: hidden\">\n        <table id=\"tt\"\n               class=\"easyui-datagrid\" style=\"width:100%;height:100%\"\n               url=\"";
echo yii\helpers\Url::to(array("list-data"));
echo "\"\n               title=\"Data Jaringan\"\n               rownumbers=\"true\" pagination=\"true\">\n            <thead>\n            <tr>\n                <th field=\"kode_registrasi\" width=\"80\">Kode Registrasi</th>\n                <th field=\"kode\" width=\"80\">Kode</th>\n                <th field=\"nama\" width=\"150\">Nama</th>\n                <th field=\"alamat\" width=\"200\">Alamat</th>\n                <th field=\"kodepos\" width=\"80\">Kodepos</th>\n                <th field=\"no_telepon\" width=\"80\">No Telepon</th>\n                <th field=\"email\" width=\"80\">Email</th>\n                <th field=\"tanggal_registrasi\" width=\"80\">Tanggal Registrasi</th>\n                <th field=\"serial_no_registrasi\" width=\"80\">Serial No Registrasi</th>\n            </tr>\n            </thead>\n        </table>\n    </div>\n    <div data-options=\"region:'center'\" style=\"height:40%;padding: 10px 20px\">\n        <form id=\"form\" method=\"post\" action=\"\">\n            <div class=\"form-control\">\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "kode_registrasi", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "kode", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::combo($model, "main_dealer_id", 300, yii\helpers\ArrayHelper::map(app\models\MainDealer::find()->all(), "id", "nama"), array("prompt" => "(Pilih)"));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::combo($model, "jaringan_kategori_id", 300, yii\helpers\ArrayHelper::map(app\models\JaringanKategori::find()->all(), "id", "nama"), array("prompt" => "(Pilih)"));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::combo($model, "merek_id", 300, yii\helpers\ArrayHelper::map(app\models\Merek::find()->all(), "id", "nama"), array("prompt" => "(Pilih)"));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "nama", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "alamat", 300);
echo "                </div>\n\n                ";
echo app\components\EasyUI::wilayah($model);
echo "\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "no_telepon", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "email", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "no_whatsapp", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "website", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "status_merchant", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "facebook", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "tanggal_registrasi", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "serial_no_registrasi", 300);
echo "                </div>\n            </div>\n        </form>\n    </div>\n    <div data-options=\"region:'south'\" style=\"height:10%;padding: 10px 20px\">\n        <a href=\"javascript:void(0)\" id=\"btn-save\" class=\"easyui-linkbutton\"\n           data-options=\"iconCls:'fam disk'\">Simpan</a>\n        <a href=\"javascript:void(0)\" id=\"btn-delete\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-cancel'\">Hapus</a>\n    </div>\n</div>\n\n<script>\n    var selectedData = {};\n    var currentID = \"\";\n\n    \$(\"#tt\").datagrid({\n        onClickRow: function (index, row) {\n            selectedData = row;\n            console.log(row);\n\n            temporaryData = row;\n\n            for (var property in selectedData) {\n                if (selectedData.hasOwnProperty(property)) {\n                    //console.log(property, selectedData[property])\n                    \$(\"#\" + property).setValue(selectedData[property]);\n                }\n            }\n            currentID = selectedData.id;\n        }\n    });\n\n    \$(\"#btn-save\").click(function () {\n        var serialize = \$(\"#form\").serialize();\n        console.log(serialize);\n        \$.ajax({\n            url: \"";
echo yii\helpers\Url::to(array("save"));
echo "?id=\" + currentID,\n            data: serialize,\n            type: \"post\",\n            dataType: \"json\",\n            success: function (msg) {\n                dialog(\"Simpan Data Sukses\");\n                \$('#tt').datagrid('reload');\n            },\n            error: function (xhr, ajaxOptions, thrownError) {\n                dialog(xhr.responseJSON.message);\n            }\n        });\n        return false;\n    });\n    \$(\"#btn-delete\").click(function () {\n        \$.ajax({\n            url: \"";
echo yii\helpers\Url::to(array("delete"));
echo "?id=\" + currentID,\n            dataType: \"json\",\n            success: function (msg) {\n                dialog(\"Hapus Data Sukses\");\n                \$('#tt').datagrid('reload');\n                currentID = \"\";\n                \$(\"#form\").form(\"clear\");\n            },\n            error: function (xhr, ajaxOptions, thrownError) {\n                dialog(xhr.responseJSON.message);\n            }\n        });\n        return false;\n    });\n\n    setTitle(\"Identitas Bengkel\");\n</script>";

?>