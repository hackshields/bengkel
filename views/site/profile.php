<?php

$this->title = "Profile";
$this->params["breadcrumbs"][] = $this->title;
echo "<div class=\"giiant-crud\">\n\n    <div class=\"panel panel-default\">\n        <div class=\"panel-heading\">\n            <h2>";
echo $model->name;
echo "</h2>\n        </div>\n\n        <div class=\"panel-body\">\n\n            <div class=\"user-form\">\n\n                ";
$form = yii\bootstrap\ActiveForm::begin(array("id" => "User", "layout" => "horizontal", "enableClientValidation" => false, "errorSummaryCssClass" => "error-summary alert alert-error", "options" => array("enctype" => "multipart/form-data")));
echo "\n                <div class=\"\">\n                    ";
$this->beginBlock("main");
echo "\n                    <p>\n                        <input type=\"tel\" hidden /> <!-- disable chrome autofill -->\n                        ";
echo $form->field($model, "password")->passwordInput(array("maxlength" => true, "autocomplete" => "off"));
echo "                        ";
echo $form->field($model, "name")->textInput(array("maxlength" => true));
echo "                        ";
echo $form->field($model, "photo_url")->widget(kartik\file\FileInput::className(), array("options" => array("accept" => "image/*"), "pluginOptions" => array("allowedFileExtensions" => array("jpg", "png", "jpeg", "gif", "bmp"), "maxFileSize" => 250)));
echo "                        ";
if ($model->photo_url != NULL) {
    echo "                            <div class=\"form-group\">\n                                <div class=\"col-sm-6 col-sm-offset-3\">\n                                    ";
    echo yii\helpers\Html::img(array("uploads/" . $model->photo_url), array("width" => "150px"));
    echo "                                </div>\n                            </div>\n                            ";
}
echo "                    </p>\n                    ";
$this->endBlock();
echo "\n                    ";
echo dmstr\bootstrap\Tabs::widget(array("encodeLabels" => false, "items" => array(array("label" => "User", "content" => $this->blocks["main"], "active" => true))));
echo "                    <hr/>\n                    ";
echo $form->errorSummary($model);
echo "                    ";
echo yii\helpers\Html::submitButton("<span class=\"glyphicon glyphicon-check\"></span> " . ($model->isNewRecord ? "Create" : "Save"), array("id" => "save-" . $model->formName(), "class" => "btn btn-success"));
echo "\n                    ";
yii\bootstrap\ActiveForm::end();
echo "\n                </div>\n\n            </div>\n\n        </div>\n\n    </div>\n\n</div>\n";

?>