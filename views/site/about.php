<?php

$this->title = "About";
$this->params["breadcrumbs"][] = $this->title;
echo "<div class=\"site-about\">\n    <h1>";
echo yii\helpers\Html::encode($this->title);
echo "</h1>\n\n    <p>\n        This is the About page. You may modify the following file to customize its content:\n    </p>\n\n    <code>";
echo __FILE__;
echo "</code>\n</div>\n";

?>