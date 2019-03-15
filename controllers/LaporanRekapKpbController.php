<?php

namespace app\controllers;

class LaporanRekapKpbController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionListKpb($tanggal1 = NULL, $tanggal2 = NULL, $motor_id = "")
    {
        $query = \app\models\ViewKpb::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()));
        if (isset($tanggal1) && isset($tanggal2)) {
            $query->andWhere("tanggal_service between '" . $tanggal1 . " 00:00:00' AND '" . $tanggal2 . " 23:59:59'");
        }
        if ($motor_id != "") {
            $query->andWhere(array("motor_id" => $motor_id));
        }
        $query->orderBy("tanggal_service DESC");
        return \app\components\DataGridUtility::process($query);
    }
    public function actionUpdateKpb($id)
    {
        $no_pkb = $_POST["no_pkb"];
        $no_rangka = $_POST["no_rangka"];
        $no_mesin = $_POST["no_mesin"];
        $tanggal_service = $_POST["tanggal_service"];
        $pkb = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        $pkb->nomor = $no_pkb;
        $waktuDaftar = strtotime($pkb->waktu_daftar);
        $pkb->waktu_daftar = $tanggal_service . " " . date("H:i:s", $waktuDaftar);
        if ($pkb->konsumen_id != null) {
            $konsumen = $pkb->konsumen;
            $konsumen->no_mesin = $no_mesin;
            $konsumen->no_rangka = $no_rangka;
            $konsumen->save();
        }
        $pkb->save();
        return \app\components\AjaxResponse::send($pkb, "Data KPB berhasil diupdate.");
    }
}

?>