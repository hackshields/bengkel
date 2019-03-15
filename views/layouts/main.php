<?php

app\assets\AppAsset::register($this);
$this->beginPage();
echo "<!DOCTYPE html>\n<html lang=\"";
echo Yii::$app->language;
echo "\">\n<head>\n    <meta charset=\"";
echo Yii::$app->charset;
echo "\"/>\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n    ";
echo yii\helpers\Html::csrfMetaTags();
echo "    <title>E-SIAP</title>\n    <!--<script src=\"";
echo Yii::$app->params["socket_url"];
echo "/socket.io/socket.io.js\"></script>-->\n    <script>\n        var baseUrl = \"";
echo Yii::$app->urlManager->baseUrl;
echo "\";\n        var socketUrl = \"";
echo Yii::$app->params["socket_url"];
echo "\";\n        var socket = io(socketUrl);\n        var currentUserId = \"";
echo Yii::$app->user->identity->id;
echo "\";\n    </script>\n    ";
$this->head();
echo "</head>\n<body class=\"white-background\">\n";
$this->beginBody();
echo $content;
$this->endBody();
echo "</body>\n</html>\n";
$this->endPage();

?>