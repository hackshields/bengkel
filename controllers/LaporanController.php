<?php

namespace app\controllers;

class LaporanController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    private function getHeaderNota($label)
    {
        $jaringan = \app\models\Jaringan::find()->where(array("id" => \app\models\Jaringan::getCurrentID()))->one();
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>" . $label . "</h2>" . "<p style='text-align:right'>Interval : " . \app\components\Tanggal::toReadableDate($_GET["tanggal1"]) . " s/d " . \app\components\Tanggal::toReadableDate($_GET["tanggal2"]) . "</p>" . "</td></tr></table>";
    }
    public function actionWpp()
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 40, "beforeRender" => function ($mpdf, $data) {
        }, "header" => \app\models\Jaringan::getInfoCetak() . "<br>WORKSHOP PERFORMANCE PARAMETER" . "<br>Periode: " . \app\components\Tanggal::toReadableDate($_GET["tanggal1"]) . " s/d " . \app\components\Tanggal::toReadableDate($_GET["tanggal2"])));
        return $this->renderPartial("wpp", array());
    }
    public function actionLbb1()
    {
        \Yii::$app->response->format = "pdf";
        ini_set("memory_limit", "8G");
        set_time_limit(3600);
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(216, 356), "marginTop" => 25, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("LAPORAN BULANAN BENGKEL 1")));
        return $this->renderPartial("lbb1");
    }
    public function actionLbb2()
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(216, 356), "marginTop" => 25, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("LAPORAN BULANAN BENGKEL 2")));
        return $this->renderPartial("lbb2");
    }
    public function actionNjbItem()
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(216, 356), "marginTop" => 40, "beforeRender" => function ($mpdf, $data) {
        }, "header" => \app\models\Jaringan::getInfoCetak() . "<br>LAPORAN NOTA JASA BENGKEL - PER ITEM" . "<br>Periode: " . \app\components\Tanggal::toReadableDate($_GET["tanggal1"]) . " s/d " . \app\components\Tanggal::toReadableDate($_GET["tanggal2"])));
        return $this->renderPartial("njb-item");
    }
    public function actionNjbNota()
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 40, "beforeRender" => function ($mpdf, $data) {
        }, "header" => \app\models\Jaringan::getInfoCetak() . "<br>LAPORAN NOTA JASA BENGKEL - PER NOTA" . "<br>Periode: " . \app\components\Tanggal::toReadableDate($_GET["tanggal1"]) . " s/d " . \app\components\Tanggal::toReadableDate($_GET["tanggal2"])));
        return $this->renderPartial("njb-nota");
    }
    public function actionNscItem()
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(216, 356), "marginTop" => 40, "beforeRender" => function ($mpdf, $data) {
        }, "header" => \app\models\Jaringan::getInfoCetak() . "<br>LAPORAN NOTA SUKU CADANG - PER ITEM" . "<br>Periode: " . \app\components\Tanggal::toReadableDate($_GET["tanggal1"]) . " s/d " . \app\components\Tanggal::toReadableDate($_GET["tanggal2"])));
        return $this->renderPartial("nsc-item");
    }
    public function actionNscNota()
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 40, "beforeRender" => function ($mpdf, $data) {
        }, "header" => \app\models\Jaringan::getInfoCetak() . "<br>LAPORAN NOTA SUKU CADANG - PER NOTA" . "<br>Periode: " . \app\components\Tanggal::toReadableDate($_GET["tanggal1"]) . " s/d " . \app\components\Tanggal::toReadableDate($_GET["tanggal2"])));
        return $this->renderPartial("nsc-nota");
    }
    public function actionPart()
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(216, 356), "marginTop" => 40, "beforeRender" => function ($mpdf, $data) {
        }, "header" => \app\models\Jaringan::getInfoCetak() . "<br>LAPORAN PENJUALAN SUKU CADANG" . "<br>Periode: " . \app\components\Tanggal::toReadableDate($_GET["tanggal1"]) . " s/d " . \app\components\Tanggal::toReadableDate($_GET["tanggal2"])));
        return $this->renderPartial("part");
    }
}

?>