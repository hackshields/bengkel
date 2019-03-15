<?php

namespace app\controllers;

class JasaController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionListData()
    {
        $query = \app\models\Jasa::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "status" => "1"));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSave($id = NULL)
    {
        if ($id == null) {
            $model = new \app\models\Jasa();
            $model->jaringan_id = \app\models\Jaringan::getCurrentID();
        } else {
            $model = \app\models\Jasa::find()->where(array("id" => $id))->one();
        }
        if ($model->load($_POST)) {
            if ($model->kode == null) {
                $jumlah = \app\models\Jasa::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()))->count();
                $model->kode = "J" . str_pad($jumlah, 3, "0", STR_PAD_LEFT);
            }
            $model->save();
            return \app\components\AjaxResponse::send($model);
        }
    }
    public function actionDelete($id)
    {
        $model = \app\models\Jasa::find()->where(array("id" => $id))->one();
        $model->status = 0;
        $model->save();
    }
}

?>