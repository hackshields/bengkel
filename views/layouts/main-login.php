<?php

app\assets\AppAsset::register($this);
$this->beginPage();
echo "<!DOCTYPE html>\n<html lang=\"";
echo Yii::$app->language;
echo "\">\n<head>\n    <meta charset=\"";
echo Yii::$app->charset;
echo "\"/>\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n    ";
echo yii\helpers\Html::csrfMetaTags();
echo "    <title>";
echo yii\helpers\Html::encode($this->title);
echo "</title>\n    ";
$this->head();
echo "</head>\n<body>\n";
$this->beginBody();
echo $content;
$this->endBody();
echo "</body>\n</html>\n";
$this->endPage();

?>