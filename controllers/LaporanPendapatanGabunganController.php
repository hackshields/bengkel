<?php

namespace app\controllers;

class LaporanPendapatanGabunganController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionLaporanPg()
    {
        ini_set("memory_limit", "8000M");
        set_time_limit(3600);
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(216, 356), "marginTop" => 25, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("LAPORAN PENDAPATAN GABUNGAN")));
        return $this->renderPartial("laporan-pg", array());
    }
    private function getHeaderNota($label)
    {
        $jaringan = \app\models\Jaringan::find()->where(array("id" => \app\models\Jaringan::getCurrentID()))->one();
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>" . $label . "</h2>" . "<p style='text-align:right'>Interval : " . \app\components\Tanggal::toReadableDate($_GET["tanggal1"]) . " s/d " . \app\components\Tanggal::toReadableDate($_GET["tanggal2"]) . "</p>" . "</td></tr></table>";
    }
}

?>