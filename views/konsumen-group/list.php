<?php

$model = new app\models\KonsumenGroup();
echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'north'\" style=\"height:50%;overflow: hidden\">\n        <table id=\"tt\"\n               class=\"easyui-datagrid\" style=\"width:100%;height:100%\"\n               url=\"";
echo yii\helpers\Url::to(array("list-data"));
echo "\"\n               title=\"Data Konsumen Group\"\n               singleselect=\"true\"\n               rownumbers=\"true\" pagination=\"true\">\n            <thead>\n            <tr>\n                <th field=\"kode\" width=\"80\">Kode</th>\n                <th field=\"nama\" width=\"200\">Nama</th>\n                <th field=\"alamat\" width=\"200\">Alamat</th>\n                <th field=\"no_telpon\" width=\"120\">No Telpon</th>\n                <th field=\"email\" width=\"150\">Email</th>\n                <th field=\"pic\" width=\"150\">Pic</th>\n                <th field=\"no_telpon_pic\" width=\"80\">No Telpon Pic</th>\n                <th field=\"tanggal_kontrak_akhir\" width=\"80\">Tanggal Kontrak Akhir</th>\n                <th field=\"plafon\" width=\"80\">Plafon</th>\n            </tr>\n            </thead>\n        </table>\n    </div>\n    <div data-options=\"region:'center'\" style=\"height:40%;padding: 10px 20px\">\n        <form id=\"form\" method=\"post\" action=\"\">\n            <div class=\"half\">\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "kode", 200);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "nama", 400);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "alamat", 400);
echo "                </div>\n\n                ";
echo app\components\EasyUI::wilayah($model);
echo "\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "kodepos", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "diskon_jasa", 200);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "diskon_suku_cadang", 200);
echo "                </div>\n            </div>\n            <div class=\"half\">\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "no_telpon", 300, array("prompt" => "+628XXXXXXXX"));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "email", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "pic", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "no_telpon_pic", 300, array("prompt" => "+628XXXXXXXX"));
echo "                </div>\n            </div>\n            <div class=\"half\">\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::input($model, "no_kontrak", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::date($model, "tanggal_kontrak_awal", 250);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::date($model, "tanggal_kontrak_akhir", 250);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "plafon", 300);
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::combo($model, "status_plafon", 300, array("Tidak", "Ya"));
echo "                </div>\n                <div class=\"form-control\">\n                    ";
echo app\components\EasyUI::number($model, "kredit", 300);
echo "                </div>\n\n            </div>\n        </form>\n    </div>\n    <div data-options=\"region:'south'\" style=\"height:10%;padding: 10px 20px\">\n        <button id=\"btn-add\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-add'\">Tambah Baru</button>\n        <button id=\"btn-save\" class=\"easyui-linkbutton\" data-options=\"iconCls:'fam disk'\">Simpan</button>\n        <button id=\"btn-delete\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-cancel'\">Hapus</button>\n    </div>\n</div>\n\n<script>\n    var group = null;\n\n    \$(\"#tt\").datagrid({\n        toolbar: addSearchToolbar('tt'),\n        onClickRow: function (index, row) {\n            group = row;\n\n            temporaryData = row;\n\n            for (var property in group) {\n                if (group.hasOwnProperty(property)) {\n                    //console.log(property, selectedData[property])\n                    \$(\"#\" + property).setValue(group[property]);\n                }\n            }\n        }\n    });\n\n    \$(\"#btn-add\").linkbutton({\n        onClick: function () {\n            \$(\"#form\").form('reset');\n            group = null;\n        }\n    });\n\n    \$(\"#btn-save\").linkbutton({\n        onClick: function () {\n            var serialize = \$(\"#form\").serialize();\n            console.log(serialize);\n            \$.ajax({\n                url: \"";
echo yii\helpers\Url::to(array("save"));
echo "\" + (group == null ? \"\" : \"?id=\" + group.id),\n                data: serialize,\n                type: \"post\",\n                dataType: \"json\",\n                success: function (msg) {\n                    if(msg.status == 200) {\n                        dialog(\"Simpan Data Sukses\");\n                        \$('#tt').datagrid('reload');\n                    }\n                },\n                error: function(xhr, ajaxOptions, thrownError){\n                    dialog(xhr.responseJSON.message);\n                }\n            });\n            return false;\n        }\n    });\n\n    \$(\"#btn-delete\").click(function () {\n        \$.ajax({\n            url: \"";
echo yii\helpers\Url::to(array("delete"));
echo "?id=\" + group.id,\n            success: function (msg) {\n                dialog(\"Hapus Data Sukses\");\n                \$('#tt').datagrid('reload');\n                \$(\"#form\").form(\"clear\");\n                group = null;\n            }\n        });\n        return false;\n    });\n\n    setTitle(\"Group Konsumen\");\n</script>";

?>