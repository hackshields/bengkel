<?php

$params = (require __DIR__ . "/params.php");
$config = array("id" => "e-siap", "name" => "E-Siap", "language" => "id_ID", "basePath" => dirname(__DIR__), "bootstrap" => array("log"), "components" => array("request" => array("cookieValidationKey" => "1234567890"), "cache" => array("class" => "yii\\caching\\FileCache"), "user" => array("identityClass" => "app\\models\\User", "enableAutoLogin" => true), "errorHandler" => array("errorAction" => "site/error"), "mailer" => array("class" => "yii\\swiftmailer\\Mailer", "useFileTransport" => true), "log" => array("traceLevel" => YII_DEBUG ? 3 : 0, "targets" => array(array("class" => "yii\\log\\FileTarget", "levels" => array("error", "warning")))), "urlManager" => array("class" => "yii\\web\\UrlManager", "showScriptName" => false, "enablePrettyUrl" => true, "rules" => array("<controller:\\w+>/<id:\\d+>" => "<controller>/view", "<controller:\\w+>/<action:\\w+>/<id:\\d+>" => "<controller>/<action>", "<controller:\\w+>/<action:\\w+>" => "<controller>/<action>")), "formatter" => array("dateFormat" => "d-MMM-Y", "datetimeFormat" => "d-MMM-Y, H:i"), "db" => require __DIR__ . "/db.php", "response" => array("formatters" => array("pdf" => array("class" => "robregonm\\pdf\\PdfResponseFormatter", "mode" => "", "defaultFontSize" => 0, "defaultFont" => "", "marginLeft" => 15, "marginRight" => 15, "marginBottom" => 16, "marginHeader" => 9, "marginFooter" => 9, "orientation" => "Landscape", "options" => array())))), "params" => $params);
if (YII_ENV_DEV) {
}
return $config;

?>