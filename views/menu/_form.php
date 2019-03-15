<?php

echo "\n";
$form = yii\bootstrap\ActiveForm::begin(array("id" => "Menu", "layout" => "horizontal", "enableClientValidation" => true, "errorSummaryCssClass" => "error-summary alert alert-error"));
echo "\n";
echo $form->field($model, "name")->textInput(array("maxlength" => true));
echo $form->field($model, "controller")->textInput(array("maxlength" => true));
echo $form->field($model, "icon")->textInput(array("class" => "form-control icp-auto"));
echo $form->field($model, "parent_id")->dropDownList(yii\helpers\ArrayHelper::map(app\models\Menu::find()->where(array("parent_id" => NULL))->orderBy("`order`")->all(), "id", "name"), array("prompt" => "Select"));
echo "<hr/>\n";
echo $form->errorSummary($model);
echo "<div class=\"row\">\n    <div class=\"col-md-offset-3 col-md-7\">\n        ";
echo yii\helpers\Html::submitButton("<i class=\"fa fa-save\"></i> Simpan", array("class" => "btn btn-success"));
echo "        ";
echo yii\helpers\Html::a("<i class=\"fa fa-chevron-left\"></i> Kembali", array("index"), array("class" => "btn btn-default"));
echo "    </div>\n</div>\n\n";
yii\bootstrap\ActiveForm::end();
echo "\n";
$this->registerJs("\$(\".icp-auto\").iconpicker();");

?>