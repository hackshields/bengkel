<?php

echo "\n";
$form = yii\bootstrap\ActiveForm::begin(array("id" => "Role", "layout" => "horizontal", "enableClientValidation" => true, "errorSummaryCssClass" => "error-summary alert alert-error"));
echo "\n";
echo $form->field($model, "name")->textInput(array("maxlength" => true));
echo "\n<hr/>\n";
echo $form->errorSummary($model);
echo "<div class=\"row\">\n    <div class=\"col-md-offset-3 col-md-7\">\n        ";
echo yii\helpers\Html::submitButton("<i class=\"fa fa-save\"></i> Simpan", array("class" => "btn btn-success"));
echo "        ";
echo yii\helpers\Html::a("<i class=\"fa fa-chevron-left\"></i> Kembali", array("index"), array("class" => "btn btn-default"));
echo "    </div>\n</div>\n\n";
yii\bootstrap\ActiveForm::end();

?>