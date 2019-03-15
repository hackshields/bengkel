<?php

namespace app\controllers;

class KaryawanController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionListData()
    {
        $query = \app\models\User::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "status" => 1))->andWhere("role_id != 1");
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSave($id = NULL)
    {
        $model = null;
        if ($id == null) {
            $angka = \app\models\User::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()))->count();
            $model = new \app\models\User();
            $model->jaringan_id = \app\models\Jaringan::getCurrentID();
            $model->kode = "K" . str_pad($angka, 3, "0", STR_PAD_LEFT);
            $model->username = $model->jaringan_id . "_" . $model->kode;
            $model->password = md5($model->kode);
        } else {
            $model = \app\models\User::find()->where(array("id" => $id))->one();
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
        $model = \app\models\User::find()->where(array("id" => $id))->one();
        $model->status = 0;
        $model->save();
    }
}

?>