<?php

namespace app\controllers;

class PartsStockOpnameController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionListOpenStockOpname()
    {
        $query = \app\models\StockOpname::find()->where(array("status_opname_id" => \app\models\StatusOpname::OPEN, "jaringan_id" => \app\models\Jaringan::getCurrentID()));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListAllSukuCadang()
    {
        $query = \app\models\SukuCadang::find();
        return \app\components\DataGridUtility::process($query);
    }
    public function actionAddOpname()
    {
        $max = \app\models\StockOpname::find()->select("max(id) as id")->one();
        $jml = \app\models\StockOpname::find()->where(array("year(tanggal_opname)" => date("Y"), "month(tanggal_opname)" => date("n")))->count();
        $so = new \app\models\StockOpname();
        $so->no_opname = date("mY") . ($max + 1) . "ST" . str_pad($jml + 1, 3, "0", STR_PAD_LEFT);
        $so->tanggal_opname = $_POST["tanggal_opname"];
        $so->status_opname_id = $_POST["status_opname_id"];
        $so->petugas_id = $_POST["petugas_id"];
        $so->jaringan_id = \app\models\Jaringan::getCurrentID();
        $so->save();
        return \app\components\AjaxResponse::send($so);
    }
    public function actionAddDetail()
    {
        $so = new \app\models\StockOpnameDetail();
        $so->jaringan_id = \app\models\Jaringan::getCurrentID();
        $so->stock_opname_id = $_POST["stock_opname_id"];
        $so->rak_id = $_POST["rak_id"];
        $so->suku_cadang_id = $_POST["suku_cadang_id"];
        $so->quantity_oh = $_POST["quantity_oh"];
        $so->quantity_sy = $_POST["quantity_sy"];
        $so->save();
        return \app\components\AjaxResponse::send($so);
    }
    public function actionListDetailStockOpname($id = NULL)
    {
        $query = \app\models\StockOpnameDetail::find()->where(array("stock_opname_id" => $id));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionUpdateStok($id, $stok)
    {
        $detail = \app\models\StockOpnameDetail::find()->where(array("id" => $id))->one();
        $detail->quantity_oh = $stok;
        $detail->save();
    }
    public function actionDeleteDetail($id)
    {
        $detail = \app\models\StockOpnameDetail::find()->where(array("id" => $id))->one();
        $detail->delete();
    }
    public function actionMarkComplete($id)
    {
        $model = \app\models\StockOpname::find()->where(array("id" => $id))->one();
        $model->status_opname_id = \app\models\StatusOpname::CLOSE;
        $model->save();
    }
    public function actionDelete($id)
    {
        $model = \app\models\StockOpname::find()->where(array("id" => $id))->one();
        foreach ($model->stockOpnameDetails as $detail) {
            $detail->delete();
        }
        $model->delete();
    }
    public function actionFormPengecekan($id)
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 25, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("FORM PENGECEKAN SPARE PART")));
        return $this->renderPartial("form-pengecekan", array("model" => \app\models\StockOpname::find()->where(array("id" => $id))->one()));
    }
    private function getHeaderNota($label)
    {
        $jaringan = \app\models\Jaringan::find()->where(array("id" => \app\models\Jaringan::getCurrentID()))->one();
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>" . $label . "</h2>" . "</td></tr></table>";
    }
    public function actionValidasiData($id)
    {
        $stockOpname = \app\models\StockOpname::find()->where(array("id" => $id))->one();
        foreach ($stockOpname->stockOpnameDetails as $detail) {
            $sc = $detail->sukuCadang->getSukuCadangJaringan();
            if ($sc != null) {
                $sc->quantity = $detail->quantity_oh;
                $sc->opname_terakhir = $stockOpname->tanggal_opname;
                $sc->save();
            } else {
                $sc = new \app\models\SukuCadangJaringan();
                $sc->jaringan_id = \app\models\Jaringan::getCurrentID();
                $sc->suku_cadang_id = $detail->suku_cadang_id;
                $sc->quantity = $detail->quantity_oh;
                $sc->harga_beli = 0;
                $sc->hpp = 0;
                $sc->quantity_booking = 0;
                $sc->quantity_max = 0;
                $sc->quantity_min = 0;
                $sc->opname_terakhir = $stockOpname->tanggal_opname;
                $sc->save();
                $detail->sukuCadang->prosesHet();
            }
        }
    }
    public function actionCetakSelisih($id)
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 25, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("LAPORAN HASIL STOCK OPNAME")));
        return $this->renderPartial("cetak-selisih", array("model" => \app\models\StockOpname::find()->where(array("id" => $id))->one()));
    }
}

?>