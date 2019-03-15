<?php

echo "\n";
$form = yii\bootstrap\ActiveForm::begin(array("id" => "User", "layout" => "horizontal", "enableClientValidation" => false, "errorSummaryCssClass" => "error-summary alert alert-error", "options" => array("enctype" => "multipart/form-data")));
echo "\n";
echo $form->field($model, "username")->textInput(array("maxlength" => true));
echo $form->field($model, "password")->passwordInput(array("maxlength" => true));
echo $form->field($model, "name")->textInput(array("maxlength" => true));
echo $form->field($model, "role_id")->dropDownList(yii\helpers\ArrayHelper::map(app\models\Role::find()->all(), "id", "name"), array("prompt" => "Select"));
echo $form->field($model, "photo_url")->widget(kartik\file\FileInput::className(), array("options" => array("accept" => "image/*"), "pluginOptions" => array("allowedFileExtensions" => array("jpg", "png", "jpeg", "gif", "bmp"), "maxFileSize" => 250)));
if ($model->photo_url != NULL) {
    echo "    <div class=\"form-group\">\n        <div class=\"col-sm-6 col-sm-offset-3\">\n            ";
    echo yii\helpers\Html::img(array("uploads/" . $model->photo_url), array("width" => "150px"));
    echo "        </div>\n    </div>\n    ";
}
echo "\n<hr/>\n<div class=\"row\">\n    <div class=\"col-md-offset-3 col-md-7\">\n        ";
echo yii\helpers\Html::submitButton("<i class=\"fa fa-save\"></i> Simpan", array("class" => "btn btn-success"));
echo "        ";
echo yii\helpers\Html::a("<i class=\"fa fa-chevron-left\"></i> Kembali", array("index"), array("class" => "btn btn-default"));
echo "    </div>\n</div>\n\n";
yii\bootstrap\ActiveForm::end();

?>