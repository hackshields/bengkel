<?php

echo "\n<div class=\"user-search\">\n\n\t";
$form = yii\widgets\ActiveForm::begin(array("action" => array("index"), "method" => "get"));
echo "\n\t\t";
echo $form->field($model, "id");
echo "\n\t\t";
echo $form->field($model, "username");
echo "\n\t\t";
echo $form->field($model, "password");
echo "\n\t\t";
echo $form->field($model, "name");
echo "\n\t\t";
echo $form->field($model, "role_id");
echo "\n\t\t\n\t\t\n\t\t\n\t\t<div class=\"form-group\">\n\t\t\t";
echo yii\helpers\Html::submitButton("Search", array("class" => "btn btn-primary"));
echo "\t\t\t";
echo yii\helpers\Html::resetButton("Reset", array("class" => "btn btn-default"));
echo "\t\t</div>\n\n\t";
yii\widgets\ActiveForm::end();
echo "\n</div>\n";

?>