<?php

namespace app\controllers;

class SukuCadangSaranController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionSave()
    {
        $model = new \app\models\SukuCadangSaran();
        if ($model->load($_POST)) {
            $model->het = 0;
            $model->suku_cadang_kategori_id = 1;
            $model->save();
        }
        return \app\components\AjaxResponse::send($model);
    }
}

?>