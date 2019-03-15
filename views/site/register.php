<?php

$this->title = "Register";
$fieldOptions1 = array("options" => array("class" => "form-group has-feedback"), "inputTemplate" => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>");
$fieldOptions2 = array("options" => array("class" => "form-group has-feedback"), "inputTemplate" => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>");
$fieldOptions3 = array("options" => array("class" => "form-group has-feedback"), "inputTemplate" => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>");
echo "\n    <div class=\"container-fluid warnadasar\">\n        <div class=\"row\">\n            <div class=\"col-md-5 col-sm-12\">\n                ";
echo yii\helpers\Html::img(array("css/logo.png"), array("class" => "img-responsive"));
echo "            </div>\n        </div>\n    </div>\n\n\n    <div class=\" container-fluid\">\n        <div class=\"row\" style=\"background: #fff\">\n            <div class=\"col-md-9 col-sm-12\">\n                ";
echo $this->render("slider");
echo "            </div>\n            <div class=\"col-md-3 col-sm-12\">\n                <div>\n                    <h3>";
echo yii\helpers\Html::a("Login", array("site/login"));
echo " | Daftar</h3>\n                    ";
$form = yii\bootstrap\ActiveForm::begin(array("id" => "register-form", "enableClientValidation" => false));
echo "                    ";
echo $form->field($model, "name", $fieldOptions1)->label(false)->textInput(array("placeholder" => $model->getAttributeLabel("name")));
echo "                    ";
echo $form->field($model, "username", $fieldOptions2)->label(false)->textInput(array("placeholder" => $model->getAttributeLabel("username")));
echo "                    ";
echo $form->field($model, "password", $fieldOptions3)->label(false)->passwordInput(array("placeholder" => $model->getAttributeLabel("password")));
echo "                    <div class=\"row\">\n                        <div class=\"col-xs-12\">\n                            ";
echo yii\helpers\Html::submitButton("<i class='fa fa-lock'></i> DAFTAR", array("class" => "btn btn-primary btn-block btn-flat", "name" => "login-button"));
echo "                        </div>\n                    </div>\n                    ";
yii\bootstrap\ActiveForm::end();
echo "                </div>\n            </div>\n        </div>\n    </div>\n";
echo $this->render("footer");

?>