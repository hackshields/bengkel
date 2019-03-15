<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
yii\debug\DebugAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php 
echo Html::csrfMetaTags();
?>
    <title><?php 
echo Html::encode($this->title);
?></title>
    <?php 
$this->head();
?>
</head>
<body>
<?php 
$this->beginBody();
echo $content;
$this->endBody();
?>
</body>
</html>
<?php 
$this->endPage();

?>