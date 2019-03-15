<?php

namespace app\controllers;

class LaporanStokAkhirController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionStokAkhir()
    {
        ini_set("memory_limit", "8000M");
        set_time_limit(3600);
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 20, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("DATA STOCK GUDANG SPARE PARTS")));
        return $this->renderPartial("stok-akhir", array());
    }
    private function getHeaderNota($label)
    {
        $jaringan = \app\models\Jaringan::find()->where(array("id" => \app\models\Jaringan::getCurrentID()))->one();
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>" . $label . "</h2>" . "</td></tr></table>\n        <h5 style='text-align:center'>per " . \app\components\Tanggal::toReadableDate(date("Y-m-d")) . "</h5>";
    }
}

?>