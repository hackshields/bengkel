<?php

namespace app\controllers;

class BengkelKoreksiNotaController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionLoad($id)
    {
        $notaJasa = \app\models\NotaJasa::find()->where(array("id" => $id))->one();
        return \yii\helpers\Json::encode(array("status" => "OK", "data" => $notaJasa));
    }
    public function actionUpdate($id, $keterangan, $status_njb_id, $karyawan_id, $user_id, $user_password)
    {
        $user = \app\models\User::find()->where(array("id" => $user_id, "password" => md5($user_password)))->one();
        $notaJasa = \app\models\NotaJasa::find()->where(array("id" => $id))->one();
        if ($user != null) {
            $notaJasa->status_njb_id = $status_njb_id;
            $notaJasa->karyawan_id = $karyawan_id;
            $notaJasa->save();
            $message = "Update berhasil";
        } else {
            $message = "Password Salah";
        }
        return \app\components\AjaxResponse::send($notaJasa, $message);
    }
    public function actionNjbCombo($id)
    {
        $output = array();
        foreach (\app\models\NotaJasa::find()->where(array("id" => $id))->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nomor);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionListNjb()
    {
        $tgl = date("Y-m-d", strtotime("now -1 day"));
        $query = \app\models\ViewNjb::find()->where(array("status_njb_id" => \app\models\StatusNjb::CLOSE, "jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("tanggal_service > '" . $tgl . "'");
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListDetailNjb($id = NULL)
    {
        $query = \app\models\NotaJasaDetail::find()->where(array("nota_jasa_id" => $id));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionUpdateDetailPembayaran($id, $beban_pembayaran_id)
    {
        $detail = \app\models\NotaJasaDetail::find()->where(array("id" => $id))->one();
        $detail->beban_pembayaran_id = $beban_pembayaran_id;
        $detail->save();
        return \app\components\AjaxResponse::send($detail);
    }
}

?>