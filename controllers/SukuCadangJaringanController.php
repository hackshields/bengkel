<?php

namespace app\controllers;

class SukuCadangJaringanController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        return $this->renderAjax("list");
    }
    public function actionListData()
    {
        $query = \app\models\SukuCadang::find();
        return \app\components\DataGridUtility::process($query);
    }
    public function actionLoad($id)
    {
        $sukuCadang = \app\models\SukuCadang::find()->where(array("id" => $id))->one();
        echo \yii\helpers\Json::encode($sukuCadang->getSukuCadangJaringan());
    }
    public function actionSave($id = NULL)
    {
        $sukuCadang = \app\models\SukuCadang::find()->where(array("id" => $id))->one();
        $model = $sukuCadang->getSukuCadangJaringan();
        if ($model->load($_POST)) {
            $model->harga_beli = intval($model->harga_beli);
            $model->harga_jual = intval($model->harga_jual);
            $model->save();
            return \app\components\AjaxResponse::send($model);
        }
    }
    public function actionDelete($id)
    {
        $sukuCadang = \app\models\SukuCadang::find()->where(array("id" => $id))->one();
        $model = $sukuCadang->getSukuCadangJaringan();
        $model->status = 0;
        $model->save();
    }
}

?>