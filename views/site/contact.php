<?php

$this->title = "Contact";
$this->params["breadcrumbs"][] = $this->title;
echo "<div class=\"site-contact\">\n    <h1>";
echo yii\helpers\Html::encode($this->title);
echo "</h1>\n\n    ";
if (Yii::$app->session->hasFlash("contactFormSubmitted")) {
    echo "\n        <div class=\"alert alert-success\">\n            Thank you for contacting us. We will respond to you as soon as possible.\n        </div>\n\n        <p>\n            Note that if you turn on the Yii debugger, you should be able\n            to view the mail message on the mail panel of the debugger.\n            ";
    if (Yii::$app->mailer->useFileTransport) {
        echo "                Because the application is in development mode, the email is not sent but saved as\n                a file under <code>";
        echo Yii::getAlias(Yii::$app->mailer->fileTransportPath);
        echo "</code>.\n                Please configure the <code>useFileTransport</code> property of the <code>mail</code>\n                application component to be false to enable email sending.\n            ";
    }
    echo "        </p>\n\n    ";
} else {
    echo "\n        <p>\n            If you have business inquiries or other questions, please fill out the following form to contact us.\n            Thank you.\n        </p>\n\n        <div class=\"row\">\n            <div class=\"col-lg-5\">\n\n                ";
    $form = yii\bootstrap\ActiveForm::begin(array("id" => "contact-form"));
    echo "\n                    ";
    echo $form->field($model, "name");
    echo "\n                    ";
    echo $form->field($model, "email");
    echo "\n                    ";
    echo $form->field($model, "subject");
    echo "\n                    ";
    echo $form->field($model, "body")->textArea(array("rows" => 6));
    echo "\n                    ";
    echo $form->field($model, "verifyCode")->widget(yii\captcha\Captcha::className(), array("template" => "<div class=\"row\"><div class=\"col-lg-3\">{image}</div><div class=\"col-lg-6\">{input}</div></div>"));
    echo "\n                    <div class=\"form-group\">\n                        ";
    echo yii\helpers\Html::submitButton("Submit", array("class" => "btn btn-primary", "name" => "contact-button"));
    echo "                    </div>\n\n                ";
    yii\bootstrap\ActiveForm::end();
    echo "\n            </div>\n        </div>\n\n    ";
}
echo "</div>\n";

?>