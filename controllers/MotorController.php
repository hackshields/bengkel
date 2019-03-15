<?php

namespace app\controllers;

class MotorController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionListData()
    {
        $query = \app\models\Motor::find()->where(array("status" => "1"));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSave($id = NULL)
    {
        if ($id == null) {
            $model = new \app\models\Motor();
        } else {
            $model = \app\models\Motor::find()->where(array("id" => $id))->one();
        }
        if ($model->load($_POST)) {
            $model->save();
            return \app\components\AjaxResponse::send($model);
        }
    }
    public function actionDelete($id)
    {
        $model = \app\models\Motor::find()->where(array("id" => $id))->one();
        $model->status = 0;
        $model->save();
    }
}

?>