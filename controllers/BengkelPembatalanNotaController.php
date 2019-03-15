<?php

namespace app\controllers;

class BengkelPembatalanNotaController extends \yii\web\Controller
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
    public function actionProsesBatal($id, $keterangan, $user_id, $user_password)
    {
        $user = \app\models\User::find()->where(array("id" => $user_id, "password" => md5($user_password)))->one();
        $notaJasa = \app\models\NotaJasa::find()->where(array("id" => $id))->one();
        if ($user != null) {
            if ($notaJasa->status_njb_id == \app\models\StatusNjb::CLOSE) {
                $notaJasa->status_njb_id = \app\models\StatusNjb::BATAL;
                $notaJasa->tanggal_batal = date("Y-m-d");
                $notaJasa->no_batal = str_replace($notaJasa->nomor, "NJB", "RNJB");
                $notaJasa->keterangan_batal = $keterangan;
                $notaJasa->save();
                $message = "Nota Jasa Berhasil Dibatalkan.";
            } else {
                $message = "Nota Jasa Sudah Dibatalkan.";
            }
        } else {
            $message = "Password Salah.";
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
    public function actionListNotaJasa()
    {
        $tgl = date("Y-m-d", strtotime("now -1 day"));
        $query = \app\models\NotaJasa::find()->where(array("status_njb_id" => \app\models\StatusNjb::CLOSE, "jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("tanggal_njb > '" . $tgl . "'");
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListDetailNotaJasa($id = NULL)
    {
        $query = \app\models\NotaJasaDetail::find()->where(array("nota_jasa_id" => $id));
        return \app\components\DataGridUtility::process($query);
    }
}

?>