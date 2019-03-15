<?php

$this->title = "Sign In";
$fieldOptions1 = array("options" => array("class" => "form-group has-feedback"), "inputTemplate" => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>");
$fieldOptions2 = array("options" => array("class" => "form-group has-feedback"), "inputTemplate" => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>");
echo "\n<style>\n    #logo {\n        width: 80%;\n        margin: 11px 10% 0px;\n    }\n    #offline {\n        text-align: center;\n        font-weight: bold;\n        font-style: italic;\n    }\n    #danger {\n        padding: 5px 10px;\n        background: #ffe4e4;\n        border-radius: 5px;\n        margin: 5px;\n        text-align: center;\n    }\n</style>\n\n\n<div id=\"win\" class=\"easyui-window\" title=\"Login\" style=\"width:300px;height:260px;\">\n    ";
if (!app\models\Setting::isSyncDone()) {
    echo "    <div id=\"danger\">\n        Anda memerlukan sinkronisasi data.\n        <br>\n        ";
    echo yii\helpers\Html::a("Klik untuk Sinkronisasi", array("sync/index"), array("class" => "easyui-linkbutton"));
    echo "    </div>\n    ";
} else {
    echo "        ";
    echo yii\helpers\Html::img(array("css/images/logo.png"), array("id" => "logo"));
    echo "    ";
}
echo "    <div id=\"offline\">\n        Offline Version (v";
echo APP_VERSION;
echo ")\n    </div>\n    ";
$form = yii\bootstrap\ActiveForm::begin(array("id" => "login-form", "enableClientValidation" => false, "options" => array("style" => "padding:10px")));
echo "    ";
echo $form->field($model, "username")->label(false)->textInput(array("placeholder" => $model->getAttributeLabel("username"), "class" => "easyui-textbox", "data-options" => "label:'Username:'", "style" => "width:90%"));
echo "    ";
echo $form->field($model, "password")->label(false)->passwordInput(array("placeholder" => $model->getAttributeLabel("password"), "class" => "easyui-textbox", "data-options" => "label:'Password:'", "style" => "width:90%"));
echo "\n    <div style=\"text-align:center;padding:5px 0\">\n        ";
echo yii\helpers\Html::submitButton("Login", array("class" => "easyui-linkbutton", "name" => "login-button"));
echo "    </div>\n\n    ";
yii\bootstrap\ActiveForm::end();
echo "</div>";

?>