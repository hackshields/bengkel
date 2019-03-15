<?php

namespace app\controllers;

class PlazaPesananController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionListPesanan()
    {
        $query = \app\models\PembeliCart::find()->where(array("jaringan_id" => null))->orWhere(array("jaringan_id" => \app\models\Jaringan::getCurrentID()));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionAccept($id)
    {
        $cart = \app\models\PembeliCart::find()->where(array("id" => $id))->one();
        if ($cart->jaringan_id != null) {
            return \yii\helpers\Json::encode(array("status" => "ERROR"));
        }
        $cart->jaringan_id = \app\models\Jaringan::getCurrentID();
        $cart->pembeli_cart_status_id = 2;
        $cart->save();
        return \yii\helpers\Json::encode(array("status" => "OK"));
    }
}

?>