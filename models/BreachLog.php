<?php

namespace app\models;

class BreachLog extends base\BreachLog
{
    public static function addLog()
    {
        $br = new BreachLog();
        $br->datetime = date("Y-m-d H:i:s");
        $br->ip_address = self::getClientIP();
        $br->user_agent = $_SERVER["HTTP_USER_AGENT"];
        $br->url = "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $br->data = \yii\helpers\Json::encode($_POST);
        $br->save();
    }
    private static function getClientIP()
    {
        $ipaddress = "";
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ipaddress = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ipaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                if (isset($_SERVER["HTTP_X_FORWARDED"])) {
                    $ipaddress = $_SERVER["HTTP_X_FORWARDED"];
                } else {
                    if (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
                        $ipaddress = $_SERVER["HTTP_FORWARDED_FOR"];
                    } else {
                        if (isset($_SERVER["HTTP_FORWARDED"])) {
                            $ipaddress = $_SERVER["HTTP_FORWARDED"];
                        } else {
                            if (isset($_SERVER["REMOTE_ADDR"])) {
                                $ipaddress = $_SERVER["REMOTE_ADDR"];
                            } else {
                                $ipaddress = "UNKNOWN";
                            }
                        }
                    }
                }
            }
        }
        return $ipaddress;
    }
}

?>