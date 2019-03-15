<?php

Yii::setAlias("@tests", dirname(__DIR__) . "/tests");
$params = (require __DIR__ . "/params.php");
$db = (require __DIR__ . "/db.php");
return array("id" => "basic-console", "basePath" => dirname(__DIR__), "bootstrap" => array("log", "gii"), "controllerNamespace" => "app\\commands", "modules" => array("gii" => "yii\\gii\\Module"), "components" => array("cache" => array("class" => "yii\\caching\\FileCache"), "log" => array("targets" => array(array("class" => "yii\\log\\FileTarget", "levels" => array("error", "warning")))), "db" => $db), "params" => $params);

?>