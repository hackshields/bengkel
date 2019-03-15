<?php

namespace app\controllers;

class PartsPenerimaanStokGudangController extends \yii\web\Controller
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
    public function actionSavePenerimaan()
    {
        $max = \app\models\PenerimaanPart::find()->select("max(id) as id")->one();
        $jml = \app\models\PenerimaanPart::find()->where(array("year(tanggal_penerimaan)" => date("Y"), "month(tanggal_penerimaan)" => date("n")))->count();
        $penerimaanNoFaktur = \app\models\PenerimaanPart::find()->where(array("no_faktur" => $_POST["no_faktur"], "jaringan_id" => \app\models\Jaringan::getCurrentID()))->one();
        $user = \Yii::$app->user->identity;
        $pen = new \app\models\PenerimaanPart();
        $pen->jaringan_id = $user->jaringan_id;
        $pen->no_spg = date("Ymd") . ($max + 1) . "SPG" . str_pad($jml + 1, 3, "0", STR_PAD_LEFT);
        $pen->no_faktur = $_POST["no_faktur"];
        $pen->supplier_id = $_POST["supplier"];
        $pen->tanggal_faktur = $_POST["tanggal_faktur"];
        $pen->pembayaran_id = $_POST["pembayaran"];
        $pen->tanggal_jatuh_tempo = $_POST["jatuh_tempo"];
        $pen->tanggal_penerimaan = $_POST["tanggal_penerimaan"];
        $pen->total = 0;
        if ($penerimaanNoFaktur != null) {
            $pen->addError("no_faktur", "No Faktur tidak boleh ada yang sama.");
        } else {
            $pen->save();
        }
        return \app\components\AjaxResponse::send($pen, "Penerimaan Baru Berhasil Ditambahkan.");
    }
    public function actionUpdatePo($id, $po_id)
    {
        $pen = \app\models\PenerimaanPart::find()->where(array("id" => $id))->one();
        $pen->purchase_order_id = $po_id;
        $pen->save();
    }
    public function actionLoadQuantityOrder($suku_cadang_id, $purchase_order_id)
    {
        $detail = \app\models\PurchaseOrderDetail::find()->where(array("suku_cadang_id" => $suku_cadang_id, "purchase_order_id" => $purchase_order_id))->one();
        return $detail->quantity_order;
    }
    public function actionSaveDetailPenerimaan($id = NULL)
    {
        $penerimaan = \app\models\PenerimaanPart::find()->where(array("id" => $_POST["penerimaan_part_id"]))->one();
        $quantity_order = 0;
        if ($penerimaan->purchase_order_id != null) {
            $detail = \app\models\PurchaseOrderDetail::find()->where(array("suku_cadang_id" => $_POST["suku_cadang_id"], "purchase_order_id" => $penerimaan->purchase_order_id))->one();
            if ($detail != null) {
                $quantity_order = $detail->quantity_order;
            }
        }
        if ($id == null) {
            $pen = \app\models\PenerimaanPartDetail::find()->where(array("penerimaan_part_id" => $_POST["penerimaan_part_id"], "suku_cadang_id" => $_POST["suku_cadang_id"]))->one();
            if ($pen == null) {
                $pen = new \app\models\PenerimaanPartDetail();
                $pen->jaringan_id = \app\models\Jaringan::getCurrentID();
                $pen->penerimaan_part_id = $_POST["penerimaan_part_id"];
                $pen->suku_cadang_id = $_POST["suku_cadang_id"];
            }
        } else {
            $pen = \app\models\PenerimaanPartDetail::find()->where(array("id" => $id))->one();
        }
        $pen->harga_beli = $_POST["harga_beli"];
        $pen->quantity_order = $quantity_order;
        $pen->quantity_supp = $_POST["quantity_supp"];
        $pen->diskon_p = $_POST["diskon_p"];
        $pen->diskon_r = $_POST["diskon_r"];
        $pen->rak_id = $_POST["rak_id"];
        $pen->total_harga = $_POST["total_harga"];
        $pen->save();
        return \app\components\AjaxResponse::send($pen, "Detail Berhasil Disimpan.");
    }
    public function actionListPenerimaanAktif()
    {
        $user = \Yii::$app->user->identity;
        $query = \app\models\PenerimaanPart::find()->where(array("jaringan_id" => $user->jaringan_id, "status_spg_id" => \app\models\StatusSpg::ENTRY, "status" => 1))->orderBy("tanggal_penerimaan DESC");
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListSukuCadang($id = NULL)
    {
        if ($id == null) {
            $user = \Yii::$app->user->identity;
            $query = \app\models\SukuCadang::find();
            return \app\components\DataGridUtility::process($query);
        }
        $user = \Yii::$app->user->identity;
        $query = \app\models\SukuCadang::find();
        $arrID = array();
        foreach (\app\models\PurchaseOrderDetail::find()->where(array("purchase_order_id" => $id))->all() as $detail) {
            $arrID[] = $detail->suku_cadang_id;
        }
        $query->where(array("id" => $arrID));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListDetailPenerimaan($id = NULL)
    {
        if ($id != null) {
            $query = \app\models\PenerimaanPartDetail::find()->where(array("penerimaan_part_id" => $id));
            return \app\components\DataGridUtility::process($query);
        }
        $query = \app\models\PenerimaanPartDetail::find()->where(array("id" => null));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionDeleteDetail($id)
    {
        \app\models\PenerimaanPartDetail::deleteAll(array("id" => $id));
    }
    public function actionLoad($id)
    {
        return \yii\helpers\Json::encode(\app\models\PenerimaanPart::find()->where(array("id" => $id))->one());
    }
    public function actionCetakNota($id)
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 40, "beforeRender" => function ($mpdf, $data) {
        }, "header" => \app\models\Jaringan::getInfoCetak() . "<h2>DAFTAR PENERIMAAN SPARE PART</h2>"));
        $penerimaaan = \app\models\PenerimaanPart::find()->where(array("id" => $id))->one();
        if ($penerimaaan->status_spg_id == \app\models\StatusSpg::ENTRY) {
            $this->prosesPascaPenerimaan($id);
        }
        return $this->renderPartial("cetak-nota", array("model" => $penerimaaan));
    }
    public function prosesPascaPenerimaan($id)
    {
        $penerimaaan = \app\models\PenerimaanPart::find()->where(array("id" => $id))->one();
        $purchaseOrder = $penerimaaan->purchaseOrder;
        $isComplete = true;
        foreach ($penerimaaan->penerimaanPartDetails as $detail) {
            $detail->sukuCadang->prosesHet();
            $sc = $detail->sukuCadang->getSukuCadangJaringan();
            if ($sc != null) {
                $sc->quantity += $detail->quantity_supp;
                $sc->save();
            }
            if ($purchaseOrder != null) {
                $detailPO = \app\models\PurchaseOrderDetail::find()->where(array("suku_cadang_id" => $detail->suku_cadang_id, "purchase_order_id" => $purchaseOrder->id))->one();
                if ($detailPO != null) {
                    $detailPO->quantity_supp = $detail->quantity_supp;
                    $detailPO->save();
                }
            }
            if ($detail->quantity_supp < $detail->quantity_order) {
                $isComplete = false;
            }
        }
        if ($isComplete && $purchaseOrder != null) {
            $purchaseOrder->purchase_order_status_id = \app\models\PurchaseOrderStatus::CLOSE;
            $purchaseOrder->save();
        }
        $penerimaaan->status_spg_id = \app\models\StatusSpg::CLOSE;
        $penerimaaan->save();
    }
}

?>