<?php

namespace app\components;

class EasyUI
{
    public static function input($model, $name, $width = 200, $option = array())
    {
        $class = \yii\helpers\StringHelper::basename(get_class($model));
        $label = $model->getAttributeLabel($name);
        $opt = array_merge(array("data-options" => "label:'" . $label . ":',labelWidth:140", "style" => "width:" . $width . "px", "class" => "easyui-component easyui-textbox", "id" => $name), $option);
        return \yii\helpers\Html::textInput($class . "[" . $name . "]", "", $opt);
    }
    public static function file($model, $name, $width = 200)
    {
        $class = \yii\helpers\StringHelper::basename(get_class($model));
        $label = $model->getAttributeLabel($name);
        return \yii\helpers\Html::textInput($class . "[" . $name . "]", "", array("data-options" => "label:'" . $label . ":',labelWidth:140", "style" => "width:" . $width . "px", "class" => "easyui-component easyui-file", "id" => $name));
    }
    public static function number($model, $name, $width = 200, $usePrecision = true, $option = array())
    {
        $prec = 0;
        if ($usePrecision) {
            $prec = 2;
        }
        $class = \yii\helpers\StringHelper::basename(get_class($model));
        $label = $model->getAttributeLabel($name);
        $opt = array_merge(array("data-options" => "label:'" . $label . ":',labelWidth:140,precision:" . $prec . ",decimalSeparator:',',groupSeparator:'.'", "style" => "width:" . $width . "px", "class" => "easyui-component easyui-numberbox", "id" => $name), $option);
        return \yii\helpers\Html::textInput($class . "[" . $name . "]", "", $opt);
    }
    public static function date($model, $name, $width = 200, $option = array())
    {
        $class = \yii\helpers\StringHelper::basename(get_class($model));
        $label = $model->getAttributeLabel($name);
        $opt = array_merge(array("data-options" => "label:'" . $label . ":',labelWidth:140", "style" => "width:" . $width . "px", "class" => "easyui-component easyui-datebox", "id" => $name), $option);
        return \yii\helpers\Html::textInput($class . "[" . $name . "]", "", $opt);
    }
    public static function combo($model, $name, $width = 200, $items, $option = array())
    {
        $class = \yii\helpers\StringHelper::basename(get_class($model));
        $label = $model->getAttributeLabel($name);
        $opt = array_merge(array("label" => $label, "labelWidth" => "140px", "style" => "width:" . $width . "px", "class" => "easyui-component easyui-combobox", "id" => $name), $option);
        return \yii\helpers\Html::dropDownList($class . "[" . $name . "]", "", $items, $opt);
    }
    public static function wilayah($model)
    {
        echo "<div id=\"dialog_list_wilayah\">\n    <table id=\"list_wilayah\" style=\"height: 100%;width: 100%\">\n        <thead>\n        <tr>\n            <th field=\"desa_nama\" width=\"80\">Desa</th>\n            <th field=\"kec_nama\" width=\"80\">Kecamatan</th>\n            <th field=\"kab_nama\" width=\"80\">Kabupaten</th>\n            <th field=\"prop_nama\" width=\"80\">Propinsi</th>\n            <th field=\"action\" width=\"80\">#</th>\n        </tr>\n        </thead>\n    </table>\n</div>\n\n        <div style=\"padding: 0px 0px 4px 140px\">\n            <button id=\"btn-search-wilayah\" class=\"easyui-linkbutton\" type=\"button\" iconCls=\"icon-search\">\n                Cari Wilayah\n            </button>\n        </div>\n\n        <div class=\"form-control\">\n            ";
        echo EasyUI::combo($model, "wilayah_propinsi_id", 300, \yii\helpers\ArrayHelper::map(\app\models\WilayahPropinsi::find()->all(), "id", "nama"), array("label" => "Propinsi", "prompt" => "(Pilih)"));
        echo "        </div>\n        <div class=\"form-control\">\n            ";
        echo EasyUI::combo($model, "wilayah_kabupaten_id", 400, array(), array("label" => "Kabupaten"));
        echo "        </div>\n        <div class=\"form-control\">\n            ";
        echo EasyUI::combo($model, "wilayah_kecamatan_id", 300, array(), array("label" => "Kecamatan"));
        echo "        </div>\n        <div class=\"form-control\">\n            ";
        echo EasyUI::combo($model, "wilayah_desa_id", 300, array(), array("label" => "Desa"));
        echo "        </div>\n        <div class=\"form-control\">\n            ";
        echo EasyUI::input($model, "kodepos", 200);
        echo "        </div>\n\n        <script>\n            var temporaryData = null;\n\n            \$(document).off(\"click\", \".btn-wilayah-gunakan\");\n            \$(document).on(\"click\", \".btn-wilayah-gunakan\", function () {\n                var desa_id = \$(this).attr(\"desa_id\");\n                var kec_id = \$(this).attr(\"kec_id\");\n                var kab_id = \$(this).attr(\"kab_id\");\n                var prop_id = \$(this).attr(\"prop_id\");\n\n                temporaryData = {\n                    wilayah_kabupaten_id : kab_id,\n                    wilayah_kecamatan_id: kec_id,\n                    wilayah_desa_id: desa_id,\n                };\n\n                \$(\"#wilayah_propinsi_id\").combobox('setValue', prop_id);\n                //\$(\"#wilayah_kabupaten_id\").combobox('setValue', kab_id);\n                //\$(\"#wilayah_kecamatan_id\").combobox('setValue', kec_id);\n                //\$(\"#wilayah_desa_id\").combobox('setValue', desa_id);\n\n\n\n                \$('#dialog_list_wilayah').window('close');\n                return false;\n            });\n\n            \$(\"#dialog_list_wilayah\").window({\n                width: 800,\n                height: 380,\n                modal: true,\n                closed: true,\n                title: \"Cari Wilayah\"\n            });\n\n            \$(\"#list_wilayah\").datagrid({\n                url: \"";
        echo \yii\helpers\Url::to(array("ajax/wilayah"));
        echo "\",\n                singleSelect: true,\n                pagination: true,\n                rownumbers: true,\n                fitColumns: true,\n                //pageSize: 19,\n                toolbar: addSearchToolbar(\"list_wilayah\"),\n            });\n\n            \$(\"#wilayah_propinsi_id\").combobox({\n                onChange: function (newVal, oldVal) {\n                    \$(\"#wilayah_kabupaten_id\").combobox('reload', '";
        echo \yii\helpers\Url::to(array("ajax/kabupaten", "id" => ""));
        echo "' + newVal);\n                    \$(\"#wilayah_kabupaten_id\").combobox('setValue', temporaryData.wilayah_kabupaten_id);\n                }\n            });\n            \$(\"#wilayah_kabupaten_id\").combobox({\n                onChange: function (newVal, oldVal) {\n                    \$(\"#wilayah_kecamatan_id\").combobox('reload', '";
        echo \yii\helpers\Url::to(array("ajax/kecamatan", "id" => ""));
        echo "' + newVal);\n                    \$(\"#wilayah_kecamatan_id\").combobox('setValue', temporaryData.wilayah_kecamatan_id);\n                }\n            });\n            \$(\"#wilayah_kecamatan_id\").combobox({\n                onChange: function (newVal, oldVal) {\n                    \$(\"#wilayah_desa_id\").combobox('reload', '";
        echo \yii\helpers\Url::to(array("ajax/desa", "id" => ""));
        echo "' + newVal);\n                    \$(\"#wilayah_desa_id\").combobox('setValue', temporaryData.wilayah_desa_id);\n                }\n            });\n            \$(\"#wilayah_desa_id\").combobox({\n                onChange: function (newVal, oldVal) {\n                    \$.ajax({\n                        url : '";
        echo \yii\helpers\Url::to(array("ajax/kodepos", "id" => ""));
        echo "' + newVal,\n                        dataType: \"text\",\n                        success: function(msg){\n                            \$(\"#kodepos\").textbox(\"setValue\", msg);\n                        }\n                    });\n                }\n            });\n\n            \$(\"#btn-search-wilayah\").linkbutton({\n                onClick: function(){\n                    \$(\"#dialog_list_wilayah\").window('open');\n                    return false;\n                }\n            })\n        </script>\n        ";
    }
}

?>