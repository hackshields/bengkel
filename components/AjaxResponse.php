<?php

namespace app\components;

class AjaxResponse
{
    const STATUS_OK = 200;
    const STATUS_ERROR = 403;
    public static function send($model, $message = "Success")
    {
        $output = array("status" => self::STATUS_OK, "code" => self::STATUS_OK, "message" => $message, "model" => $model);
        if (count($model->errors) != 0) {
            $output["status"] = self::STATUS_ERROR;
            $output["code"] = self::STATUS_ERROR;
            $output["message"] = Utility::processError($model->errors);
            \Yii::$app->response->statusCode = self::STATUS_ERROR;
        }
        return \yii\helpers\Json::encode($output);
    }
}

?>