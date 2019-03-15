<?php

namespace app\controllers;

class BengkelAbsensiMekanikController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionAddAbsensi()
    {
        $jumlah = intval(\app\models\Absensi::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "date(jam_masuk)" => date("Y-m-d"), "karyawan_id" => $_POST["karyawan_id"]))->count());
        if (0 < $jumlah) {
            return \yii\helpers\Json::encode(array("code" => 400, "message" => "Absensi tidak boleh dua kali sehari.", "status" => 400));
        }
        $so = new \app\models\Absensi();
        $so->karyawan_id = $_POST["karyawan_id"];
        $so->absensi_status_id = $_POST["absensi_status_id"];
        $so->keterangan = $_POST["keterangan"];
        $so->jam_masuk = date("Y-m-d H:i:s");
        $so->jaringan_id = \app\models\Jaringan::getCurrentID();
        $so->save();
        $karyawan = $so->karyawan;
        $karyawan->is_on_duty = 0;
        $karyawan->save();
        return \app\components\AjaxResponse::send($so);
    }
    public function actionPulang($id)
    {
        $data = \app\models\Absensi::find()->where(array("id" => $id))->one();
        $data->jam_pulang = date("Y-m-d H:i:s");
        $data->save();
        return \app\components\AjaxResponse::send($data);
    }
    public function actionListAbsensiHariIni()
    {
        $query = \app\models\Absensi::find()->where(array("date(jam_masuk)" => date("Y-m-d"), "jaringan_id" => \app\models\Jaringan::getCurrentID()));
        return \app\components\DataGridUtility::process($query);
    }
}

?>