<?php

namespace app\controllers;

class MerekController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionListData()
    {
        $page = $_POST["page"];
        $rows = $_POST["rows"];
        if ($page == null) {
            $page = 1;
        }
        if ($rows == null) {
            $rows = 10;
        }
        $user = \Yii::$app->user->identity;
        $query = \app\models\Merek::find()->where(array("jaringan_id" => $user->jaringan_id, "status" => "1"));
        $arr = $query->offset(($page - 1) * $rows)->limit($rows)->all();
        $output = array("rows" => $arr, "total" => $query->count());
        echo \yii\helpers\Json::encode($output);
    }
    public function actionSave($id = NULL)
    {
        if ($id == null) {
            $model = new \app\models\Merek();
            if ($model->load($_POST)) {
                if ($model->save()) {
                    return \yii\helpers\Json::encode(array("status" => "OK", "message" => "Simpan Data Berhasil"));
                }
                return \yii\helpers\Json::encode(array("status" => "ERROR", "message" => \app\components\Utility::processError($model->errors)));
            }
        } else {
            $model = \app\models\Merek::find()->where(array("id" => $id))->one();
            if ($model->load($_POST)) {
                if ($model->save()) {
                    return \yii\helpers\Json::encode(array("status" => "OK", "message" => "Simpan Data Berhasil"));
                }
                return \yii\helpers\Json::encode(array("status" => "ERROR", "message" => \app\components\Utility::processError($model->errors)));
            }
        }
    }
    public function actionDelete($id)
    {
        $model = \app\models\Merek::find()->where(array("id" => $id))->one();
        $model->status = 0;
        $model->save();
    }
}

?>