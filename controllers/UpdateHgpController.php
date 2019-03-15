<?php

namespace app\controllers;

class UpdateHgpController extends \yii\web\Controller
{
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionListData()
    {
        return \yii\helpers\Json::encode(array());
    }
}

?>