<?php

namespace app\controllers;

class BengkelKoreksiPerintahKerjaController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionLoad($id)
    {
        return \yii\helpers\Json::encode(\app\models\PerintahKerja::find()->where(array("id" => $id))->one());
    }
    public function actionListPekerjaan()
    {
        $query = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "date(waktu_daftar)" => date("Y-m-d"), "perintah_kerja_status_id" => array(\app\models\PerintahKerjaStatus::TUNGGU, \app\models\PerintahKerjaStatus::DIKERJAKAN, \app\models\PerintahKerjaStatus::SELESAI, \app\models\PerintahKerjaStatus::TUNDA, \app\models\PerintahKerjaStatus::NOTA)));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSave($id)
    {
        $pkb = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        $pkb->tanggal_ass = $_POST["tanggal_ass"];
        $pkb->km = $_POST["km"];
        $pkb->durasi_service = $_POST["durasi_service"];
        $pkb->karyawan_id = $_POST["karyawan_id"];
        $pkb->save();
        return \app\components\AjaxResponse::send($pkb);
    }
}

?>