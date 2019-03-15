<?php

if ($_SERVER["SERVER_NAME"] == "localhost") {
    return array("class" => "yii\\db\\Connection", "dsn" => "mysql:host=localhost;dbname=bengkel", "username" => "root", "password" => "root", "charset" => "utf8");
}
return array("class" => "yii\\db\\Connection", "dsn" => "mysql:host=localhost;dbname=esiap", "username" => "root", "password" => "root", "charset" => "utf8");

?>