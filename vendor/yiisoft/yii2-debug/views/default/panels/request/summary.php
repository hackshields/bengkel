<?php

/* @var $panel yii\debug\panels\RequestPanel */
use yii\helpers\Html;
use yii\web\Response;
$statusCode = $panel->data['statusCode'];
if ($statusCode === null) {
    $statusCode = 200;
}
if ($statusCode >= 200 && $statusCode < 300) {
    $class = 'label-success';
} elseif ($statusCode >= 300 && $statusCode < 400) {
    $class = 'label-info';
} else {
    $class = 'label-important';
}
$statusText = Html::encode(isset(Response::$httpStatuses[$statusCode]) ? Response::$httpStatuses[$statusCode] : '');
?>
<div class="yii-debug-toolbar-block">
    <a href="<?php 
echo $panel->getUrl();
?>" title="Status code: <?php 
echo $statusCode;
?> <?php 
echo $statusText;
?>">Status <span class="label <?php 
echo $class;
?>"><?php 
echo $statusCode;
?></span></a>
    <a href="<?php 
echo $panel->getUrl();
?>" title="Action: <?php 
echo $panel->data['action'];
?>">Route <span class="label"><?php 
echo $panel->data['route'];
?></span></a>
</div><?php 

?>