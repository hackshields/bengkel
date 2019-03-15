<?php

namespace app\controllers;

class PartsOrderSukuCadangController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionListSupplier()
    {
        $query = \app\models\Supplier::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "status" => "1"));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSupplierCombo($id)
    {
        $output = array();
        foreach (\app\models\Supplier::find()->where(array("id" => $id))->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nama);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionSendToSupplier($id)
    {
        $po = \app\models\PurchaseOrder::find()->where(array("id" => $id))->one();
        $po->purchase_order_status_id = \app\models\PurchaseOrderStatus::SENT;
        $po->save();
        return \app\components\AjaxResponse::send($po, "PO Berhasil Dikirim Ke Supplier.");
    }
    public function actionForceClose($id)
    {
        $po = \app\models\PurchaseOrder::find()->where(array("id" => $id))->one();
        $po->purchase_order_status_id = \app\models\PurchaseOrderStatus::CLOSE;
        $po->save();
        return \app\components\AjaxResponse::send($po, "PO Berhasil Diubah ke Close secara Manual.");
    }
    public function actionListPurchaseOrder()
    {
        $user = \Yii::$app->user->identity;
        $query = \app\models\PurchaseOrder::find()->where(array("jaringan_id" => $user->jaringan_id, "status" => "1", "purchase_order_status_id" => array(\app\models\PurchaseOrderStatus::ENTRY, \app\models\PurchaseOrderStatus::SENT)));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSavePurchaseOrder($id = NULL)
    {
        $purchase_order_tipe_id = $_POST["purchase_order_tipe_id"];
        $supplier_id = $_POST["supplier_id"];
        $tanggal_po = $_POST["tanggal_po"];
        if ($id == null) {
            $max = \app\models\PurchaseOrder::find()->select("max(id) as id")->one();
            $jml = \app\models\PurchaseOrder::find()->where(array("year(tanggal_pembuatan)" => date("Y"), "month(tanggal_pembuatan)" => date("n")))->count();
            $po = new \app\models\PurchaseOrder();
            $po->jaringan_id = \app\models\Jaringan::getCurrentID();
            $po->nomor = str_pad($jml + 1, 3, "0", STR_PAD_LEFT) . "/REG-" . str_pad($max + 1, 6, "0", STR_PAD_LEFT) . "/" . date("m") . "/" . date("Y");
            $po->purchase_order_tipe_id = $purchase_order_tipe_id;
            $po->tanggal_pembuatan = $tanggal_po;
            $po->supplier_id = $supplier_id;
            $po->purchase_order_status_id = \app\models\PurchaseOrderStatus::ENTRY;
            $po->status = 1;
            $po->created_at = date("Y-m-d H:i:s");
            $po->created_by = \app\models\User::getCurrentID();
            $po->save();
            return \app\components\AjaxResponse::send($po, "PO Berhasil Ditambahkan.");
        }
        $po = \app\models\PurchaseOrder::find()->where(array("id" => $id))->one();
        $po->tanggal_pembuatan = $tanggal_po;
        $po->purchase_order_tipe_id = $purchase_order_tipe_id;
        $po->supplier_id = $supplier_id;
        $po->save();
        return \app\components\AjaxResponse::send($po, "PO Berhasil Di-update.");
    }
    public function actionListSukuCadang()
    {
        $query = \app\models\SukuCadang::find();
        return \app\components\DataGridUtility::process($query);
    }
    public function actionAddDetail($purchase_order_id, $suku_cadang_id)
    {
        $detail = new \app\models\PurchaseOrderDetail();
        $detail->purchase_order_id = $purchase_order_id;
        $detail->suku_cadang_id = $suku_cadang_id;
        $detail->quantity_order = 1;
        $po = \app\models\PurchaseOrder::find()->where(array("id" => $purchase_order_id))->one();
        if ($po->purchase_order_status_id != \app\models\PurchaseOrderStatus::ENTRY) {
            $detail->addError("purchase_order_id", "PO sudah di-lock. Penambahan item tidak diperbolehkan.");
        } else {
            $detail->save();
        }
        return \app\components\AjaxResponse::send($detail);
    }
    public function actionListPurchaseOrderDetail($id)
    {
        $query = \app\models\PurchaseOrderDetail::find()->where(array("purchase_order_id" => $id));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionEditDetail($id)
    {
        $detail = \app\models\PurchaseOrderDetail::find()->where(array("id" => $id))->one();
        $detail->quantity_order = $_POST["quantity_order"];
        $detail->quantity_supp = $_POST["quantity_supp"];
        $detail->quantity_back_order = $_POST["quantity_back_order"];
        $detail->save();
        return \app\components\AjaxResponse::send($detail);
    }
    public function actionDeleteDetail($id)
    {
        $detail = \app\models\PurchaseOrderDetail::find()->where(array("id" => $id))->one();
        $detail->delete();
        return \app\components\AjaxResponse::send($detail);
    }
    private function getHeaderNota($label)
    {
        $jaringan = \app\models\Jaringan::find()->where(array("id" => \app\models\Jaringan::getCurrentID()))->one();
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>" . $label . "</h2>" . "</td></tr></table>";
    }
    public function actionCetakNota($id)
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 25, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("PURCHASE ORDER")));
        return $this->renderPartial("cetak-nota", array("model" => \app\models\PurchaseOrder::find()->where(array("id" => $id))->one()));
    }
}

?>