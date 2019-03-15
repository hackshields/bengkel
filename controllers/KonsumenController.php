<?php

namespace app\controllers;

class KonsumenController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionListData()
    {
        $query = \app\models\Konsumen::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSave($id = NULL)
    {
        if ($id == null) {
            $model = new \app\models\Konsumen();
            $model->jaringan_id = \app\models\Jaringan::getCurrentID();
        } else {
            $model = \app\models\Konsumen::find()->where(array("id" => $id))->one();
        }
        if ($model->load($_POST)) {
            if ($model->wilayah_propinsi_id == "") {
                $model->wilayah_propinsi_id = null;
            }
            if ($model->wilayah_kabupaten_id == "") {
                $model->wilayah_kabupaten_id = null;
            }
            if ($model->wilayah_kecamatan_id == "") {
                $model->wilayah_kecamatan_id = null;
            }
            if ($model->wilayah_desa_id == "") {
                $model->wilayah_desa_id = null;
            }
            $model->save();
            return \app\components\AjaxResponse::send($model);
        }
    }
    public function actionDelete($id)
    {
        $model = \app\models\Konsumen::find()->where(array("id" => $id))->one();
        $model->status = 0;
        $model->save();
    }
}

?>