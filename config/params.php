<?php

if ($_SERVER["SERVER_NAME"] == "localhost") {
    return array("socket_url" => "http://localhost:9999", "server_url" => "http://localhost/e-siap/server/web");
}
return array("socket_url" => "http://" . $_SERVER["SERVER_NAME"] . ":9999", "server_url" => "http://app.e-siap.com/web");

?>