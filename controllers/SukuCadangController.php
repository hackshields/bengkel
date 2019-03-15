<?php

namespace app\controllers;

class SukuCadangController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionListData()
    {
        $query = \app\models\SukuCadangMaster::find();
        return \app\components\DataGridUtility::process($query);
    }
    public function actionLoad($id)
    {
        echo \yii\helpers\Json::encode(\app\models\SukuCadang::find()->where(array("id" => $id))->one());
    }
    public function actionSave($id = NULL)
    {
        if ($id == null) {
            $model = new \app\models\SukuCadang();
            if ($model->load($_POST)) {
                $model->save();
            }
        } else {
            $model = \app\models\SukuCadang::find()->where(array("id" => $id))->one();
            if ($model->load($_POST)) {
                $model->save();
            }
        }
        return \app\components\AjaxResponse::send($model);
    }
    public function actionDelete($id)
    {
        $model = \app\models\SukuCadang::find()->where(array("id" => $id))->one();
        $model->status = 0;
        $model->save();
    }
}

?>