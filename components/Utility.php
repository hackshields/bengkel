<?php

namespace app\components;

class Utility
{
    public static function processError($arr)
    {
        $output = array();
        foreach ($arr as $key => $value) {
            $output[] = implode(", ", $value);
        }
        return implode(" ", $output) . "";
    }
    public static function getActionButton($model, $deleteUrl)
    {
        return \yii\helpers\Html::button("Hapus", array("class" => "easyui-linkbutton", "data_id" => $model->id, "onclick" => "if(confirm('Apakah Anda yakin ingin menghapus data ini ?')){\n                        var ini = \$(this);\n                        \$.ajax({ url : '" . $deleteUrl . "', success : function(){\n                            ini.closest('.datagrid-f').datagrid('reload');\n                        } });\n                    };return false"));
    }
    public static function getKonsumenAddButton($comboSelector = "#konsumen_id", $label = "Konsumen")
    {
        $model = new \app\models\Konsumen();
        echo "<div id=\"dialog_search_konsumen_full\" class=\"easyui-window\">\n    <div class=\"easyui-layout\" >\n        <div data-options=\"region:'west',border:false\" style=\"width: 50%;padding: 10px\">\n            <form id=\"konsumen_form_1\">\n                <div class=\"form-control\">\n                    ";
        echo EasyUI::input($model, "nopol", 230);
        echo "                </div>\n                <div class=\"form-control\">\n                    ";
        echo EasyUI::combo($model, "jenis_identitas", 300, array("ktp" => "KTP", "sim" => "SIM", "kk" => "KK"));
        echo "                </div>\n                <div class=\"form-control\">\n                    ";
        echo EasyUI::input($model, "no_identitas", 300);
        echo "                </div>\n                <div class=\"form-control\">\n                    ";
        echo EasyUI::input($model, "nama_identitas", 400);
        echo "                </div>\n                <div class=\"form-control\">\n                    ";
        echo EasyUI::input($model, "nama_pengguna", 400);
        echo "                </div>\n                <div class=\"form-control\">\n                    ";
        echo EasyUI::input($model, "no_telepon", 250);
        echo "                </div>\n                <div class=\"form-control\">\n                    ";
        echo EasyUI::input($model, "alamat", 400);
        echo "                </div>\n\n                ";
        echo EasyUI::wilayah($model);
        echo "\n                <div class=\"form-control\">\n                    ";
        echo EasyUI::combo($model, "jenis_kelamin", 250, array("L" => "Laki-laki", "P" => "Perempuan"), array("prompt" => "(Pilih)"));
        echo "                </div>\n\n                <div class=\"form-control\">\n                    ";
        echo EasyUI::combo($model, "konsumen_group_id", 300, \yii\helpers\ArrayHelper::map(\app\models\KonsumenGroup::find()->all(), "id", "nama"), array());
        echo "                </div>\n            </form>\n        </div>\n        <div data-options=\"region:'east',border:false\" style=\"width: 50%;padding: 10px\">\n            <form id=\"konsumen_form_2\">\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "email", 400);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "no_whatsapp", 250);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "facebook", 400);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "instagram", 400);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "twitter", 400);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "tempat_lahir", 300);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::date($model, "tanggal_lahir", 250);
        echo "            </div>\n\n            <div class=\"form-control\">\n                ";
        echo EasyUI::combo($model, "agama", 300, array("Islam" => "Islam", "Katolik" => "Katolik", "Protestan" => "Protestan", "Hindu" => "Hindu", "Buddha" => "Buddha"), array("prompt" => "(Pilih)"));
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::combo($model, "pendidikan", 300, array("SLTP" => "SLTP", "SLTA" => "SLTA", "STM/SMK" => "STM/SMK", "DIPLOMA" => "DIPLOMA", "SARJANA" => "SARJANA", "PASCA SARJANA" => "PASCA SARJANA"), array("prompt" => "(Pilih)"));
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "pekerjaan", 300);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::combo($model, "motor_id", 500, \yii\helpers\ArrayHelper::map(\app\models\Motor::find()->all(), "id", "namaLengkap"), array("prompt" => "(Pilih)"));
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "no_mesin", 300);
        echo "                <span id=\"no_mesin_info\" style=\"color:#ff0000\"></span>\n            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "no_rangka", 300);
        echo "                <span id=\"no_rangka_info\" style=\"color:#ff0000\"></span>\n            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "tahun_rakit", 200);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::date($model, "tanggal_beli", 250);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "nama_dealer_beli", 300);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "kota_dealer_beli", 300);
        echo "            </div>\n            <div class=\"form-control\">\n                ";
        echo EasyUI::input($model, "sms", 300);
        echo "            </div>\n            </form>\n        </div>\n    </div>\n</div>\n<script>\nvar w = \$(window).width();\nvar h = \$(window).height();\n\$(\"#dialog_search_konsumen_full\").dialog({\n    width: 1200,\n    height: 600,\n    modal: true,\n    closed: true,\n    draggable : false,\n    resizable: false,\n    minimizable: false,\n    collapsible: false,\n    title: \"Tambah Konsumen\",\n    buttons:[{\n        text:'Simpan',\n        iconCls:'icon-save',\n        handler:function(){\n            var serialize = \$(\"#konsumen_form_1\").serialize() + \"&\" + \$(\"#konsumen_form_2\").serialize();\n            console.log(serialize);\n            \$.ajax({\n                url: \"";
        echo \yii\helpers\Url::to(array("ajax/simpan-konsumen"));
        echo "\",\n                data: serialize,\n                type: \"post\",\n                dataType: \"json\",\n                success: function (msg) {\n                    if(msg.status == 200) {\n                        dialog(\"Simpan Data Sukses\");\n                        \$(\"#dialog_search_konsumen_full\").dialog(\"close\");\n\n                        var data_id = msg.data.id;\n\n                        \$(\"";
        echo $comboSelector;
        echo "\").combobox(\"reload\", \"";
        echo \yii\helpers\Url::to(array("ajax/nopol-combo"));
        echo "?id=\" + data_id);\n                        \$(\"";
        echo $comboSelector;
        echo "\").combobox(\"setValue\", data_id);\n\n                        \$(\"#konsumen_nama\").textbox(\"setValue\", msg.data.nama_identitas);\n                        \$(\"#konsumen_no_telepon\").textbox(\"setValue\", msg.data.no_telepon);\n                        \$(\"#konsumen_no_mesin\").textbox(\"setValue\", msg.data.no_mesin);\n                        \$(\"#konsumen_motor_id\").combobox(\"select\", msg.data.motor_id).combobox('enable');\n                    }\n                },\n                error: function(xhr, ajaxOptions, thrownError){\n                    dialog(xhr.responseJSON.message);\n                }\n            });\n        }\n    },{\n        text:'Batal',\n        iconCls:'icon-clear',\n        handler:function(){\n            \$(\"#dialog_search_konsumen_full\").dialog(\"close\");\n        }\n    }]\n});\n\n\$.parser.parse(\"#dialog_search_konsumen_full\");\n\n\$(document).keyup(function(e) {\n    if (e.keyCode == 27) {\n        \$(\"#dialog_search_konsumen_full\").dialog(\"close\");\n    }\n});\n\n\$(\"#btn_add_konsumen\").linkbutton({\n    onClick : function(){\n        \$(\"#dialog_search_konsumen_full\").dialog(\"open\");\n        \$(\"#konsumen_form_1\").form('reset');\n        \$(\"#konsumen_form_2\").form('reset');\n        \$(\"#no_mesin_info\").html(\"\");\n        \$(\"#no_rangka_info\").html(\"\");\n    }\n});\n\n//focus on enter\n\$('#nopol').textbox('textbox').keydown(function(e){\n    console.log(e.keyCode);\n});\n\nvar easyuiComponent = [];\n\$(\".easyui-component\").each(function(){\n    easyuiComponent.push(\$(this));\n});\nsetTimeout(function(){\n    for(var i=0;i<easyuiComponent.length;i++){\n        var comp = easyuiComponent[i];\n        if(i < easyuiComponent.length-1){\n            comp.textbox('textbox').keypress(function(e){\n                if(e.keyCode == 13){\n                    var nextCmp = \$(':input:visible:eq(' + (\$(':input:visible').index(this) + 1) + ')')\n                    nextCmp.focus();\n                }\n            });\n        }\n    }\n}, 1000);\n\n\$(\"#no_mesin\").textbox({\n    onChange: function(){\n        \$.ajax({\n            url : \"";
        echo \yii\helpers\Url::to(array("ajax/no-mesin"));
        echo "?no=\" + \$(\"#no_mesin\").textbox('getValue'),\n            dataType : \"json\",\n            success : function(msg){\n                \$(\"#no_mesin_info\").html(msg.message);\n            }\n        });\n    }\n});\n\n\$(\"#no_rangka\").textbox({\n    onChange: function(){\n        \$.ajax({\n            url : \"";
        echo \yii\helpers\Url::to(array("ajax/no-rangka"));
        echo "?no=\" + \$(\"#no_rangka\").textbox('getValue'),\n            dataType : \"json\",\n            success : function(msg){\n                \$(\"#no_rangka_info\").html(msg.message);\n            }\n        });\n    }\n});\n\n\$(\"#nopol\").textbox({\n    onChange: function(){\n        var nopol = \$(\"#nopol\").textbox('getValue');\n        \$(\"#nopol\").textbox('setValue', nopol.toUpperCase())\n    }\n});\n\n\n\$(\"#nopol\").textbox('textbox').mask('HP XZZZ PPP', {\n    translation: {\n        'H': {\n            pattern: /[A-Za-z]/, optional: false\n        },\n        'P': {\n            pattern: /[A-Za-z]/, optional: true\n        },\n        'X': {\n            pattern: /[0-9]/, optional: false\n        },\n        'Z': {\n            pattern: /[0-9]/, optional: true\n        },\n        placeholder: \"__ ____ ___\"\n    }\n});\n\nconsole.log(\$(\"#nopol\").textbox('textbox'));\n\n</script>\n        ";
        return \yii\helpers\Html::button($label, array("class" => "easyui-linkbutton", "id" => "btn_add_konsumen", "data-options" => "iconCls:'icon-add'"));
    }
}

?>