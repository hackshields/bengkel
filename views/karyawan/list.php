<?php

$model = new app\models\User();
echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'north'\" style=\"height:50%;overflow: hidden\">\n        <table id=\"tt\"\n               class=\"easyui-datagrid\" style=\"width:100%;height:100%\"\n               url=\"";
echo yii\helpers\Url::to(array("list-data"));
echo "\"\n               title=\"Data Karyawan\"\n               fitColumns=\"true\"\n               singleselect=\"true\"\n               rownumbers=\"true\" pagination=\"true\">\n            <thead>\n            <tr>\n                <th field=\"kode\" width=\"80\" align=\"center\">Kode</th>\n                <th field=\"name\" width=\"300\">Nama</th>\n                <th field=\"role_name\" width=\"150\" align=\"center\">Jabatan</th>\n                <th field=\"alamat\" width=\"300\">Alamat</th>\n                <th field=\"no_telpon\" width=\"100\">No Telpon</th>\n                <th field=\"tanggal_lahir\" width=\"120\" align=\"center\">Tanggal Lahir</th>\n                <th field=\"agama\" width=\"80\" align=\"center\">Agama</th>\n                <th field=\"pendidikan\" width=\"150\">Pendidikan</th>\n            </tr>\n            </thead>\n        </table>\n    </div>\n    <div data-options=\"region:'center'\" style=\"height:40%;padding: 10px 20px\">\n        <form id=\"form\" method=\"post\" action=\"\">\n            <div class=\"form-control\">\n                <div style=\"width: 49%;float: left;\">\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "kode", 200, array("disabled" => true));
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "name", 400);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "alamat", 400);
echo "                    </div>\n\n                    ";
echo app\components\EasyUI::wilayah($model);
echo "\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "kodepos", 200);
echo "                    </div>\n                </div>\n                <div style=\"width: 49%;float: left;\">\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "no_telpon", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "email", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::input($model, "tempat_lahir", 300);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::date($model, "tanggal_lahir", 250);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "agama", 300, array("Islam" => "Islam", "Katolik" => "Katolik", "Protestan" => "Protestan", "Hindu" => "Hindu", "Buddha" => "Buddha"), array("prompt" => "(Pilih)"));
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "jenis_kelamin", 300, array("L" => "Laki-laki", "P" => "Perempuan"), array("prompt" => "(Pilih)"));
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "role_id", 300, yii\helpers\ArrayHelper::map(app\models\Role::find()->where("id != 1")->all(), "id", "name"), array("prompt" => "(Pilih)"));
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::combo($model, "pendidikan", 300, array("SLTP" => "SLTP", "SLTA" => "SLTA", "STM/SMK" => "STM/SMK", "DIPLOMA" => "DIPLOMA", "SARJANA" => "SARJANA", "PASCA SARJANA" => "PASCA SARJANA"), array("prompt" => "(Pilih)"));
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::date($model, "tanggal_masuk", 250);
echo "                    </div>\n                    <div class=\"form-control\">\n                        ";
echo app\components\EasyUI::date($model, "tanggal_keluar", 250);
echo "                    </div>\n                </div>\n            </div>\n        </form>\n    </div>\n    <div data-options=\"region:'south'\" style=\"height:10%;padding: 10px 20px\">\n        <button id=\"btn-add\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-add'\">Tambah Baru</button>\n        <button id=\"btn-save\" class=\"easyui-linkbutton\" data-options=\"iconCls:'fam disk'\">Simpan</button>\n        <button id=\"btn-delete\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-cancel'\">Hapus</button>\n    </div>\n</div>\n\n<script>\n    var karyawan = null;\n\n    \$(\"#tt\").datagrid({\n        toolbar: addSearchToolbar('tt'),\n        onClickRow: function (index, row) {\n            karyawan = row;\n\n            console.log(row);\n            temporaryData = row;\n\n            for (var property in karyawan) {\n                if (karyawan.hasOwnProperty(property)) {\n                    //console.log(property, selectedData[property])\n                    \$(\"#\" + property).setValue(karyawan[property]);\n                }\n            }\n        }\n    });\n\n    \$(\"#btn-add\").linkbutton({\n        onClick: function () {\n            \$(\"#form\").form('reset');\n            karyawan = null;\n        }\n    });\n\n    \$(\"#btn-save\").linkbutton({\n        onClick: function () {\n            var serialize = \$(\"#form\").serialize();\n            console.log(serialize);\n            \$.ajax({\n                url: \"";
echo yii\helpers\Url::to(array("save"));
echo "\" + (karyawan == null ? \"\" : \"?id=\" + karyawan.id),\n                data: serialize,\n                type: \"post\",\n                dataType: \"json\",\n                success: function (msg) {\n                    if(msg.status == 200) {\n                        dialog(\"Simpan Data Sukses\");\n                        \$('#tt').datagrid('reload');\n                    }\n                },\n                error: function(xhr, ajaxOptions, thrownError){\n                    dialog(xhr.responseJSON.message);\n                }\n            });\n            return false;\n        }\n    });\n\n    \$(\"#btn-delete\").click(function () {\n        \$.ajax({\n            url: \"";
echo yii\helpers\Url::to(array("delete"));
echo "?id=\" + karyawan.id,\n            success: function (msg) {\n                dialog(\"Hapus Data Sukses\");\n                \$('#tt').datagrid('reload');\n                \$(\"#form\").form(\"clear\");\n                karyawan = null;\n            }\n        });\n        return false;\n    });\n\n    setTitle(\"Karyawan\");\n</script>";

?>