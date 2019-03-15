<?php

namespace app\controllers;

class SupplierController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionListData()
    {
        $query = \app\models\Supplier::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "status" => "1"));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSave($id = NULL)
    {
        if ($id == null) {
            $model = new \app\models\Supplier();
            $model->jaringan_id = \app\models\Jaringan::getCurrentID();
        } else {
            $model = \app\models\Supplier::find()->where(array("id" => $id))->one();
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
        $model = \app\models\Supplier::find()->where(array("id" => $id))->one();
        $model->status = 0;
        $model->save();
    }
}

?>