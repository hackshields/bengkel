<?php

namespace app\controllers;

class PartsPengeluaranRetailController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionNopkbCombo($id)
    {
        $output = array();
        foreach (\app\models\PerintahKerja::find()->where(array("id" => $id))->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nomor);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionPkbInfo($id)
    {
        return \yii\helpers\Json::encode(\app\models\PerintahKerja::find()->where(array("id" => $id))->one());
    }
    public function actionNopolCombo($id)
    {
        $output = array();
        $output[] = array("value" => "", "text" => "");
        foreach (\app\models\Konsumen::find()->where(array("id" => $id))->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nopol);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionInfoCombo($id)
    {
        return \yii\helpers\Json::encode(\app\models\Konsumen::find()->where(array("id" => $id))->one());
    }
    public function actionListOpenPengeluaranRetail()
    {
        $query = \app\models\PengeluaranPart::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "date(tanggal_pengeluaran)" => date("Y-m-d"), "status_nsc_id" => \app\models\StatusNsc::ENTRY));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListAllSukuCadang()
    {
        $query = \app\models\SukuCadang::find();
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListPkb()
    {
        $query = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => \app\models\PerintahKerjaStatus::SELESAI, "tanggal_ass" => date("Y-m-d")));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListKonsumen()
    {
        $query = \app\models\Konsumen::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSavePengeluaran($id = NULL)
    {
        if ($id != null) {
            $so = \app\models\PengeluaranPart::find()->where(array("id" => $id))->one();
        } else {
            $so = new \app\models\PengeluaranPart();
            $so->generateNomorNota();
            $so->tanggal_pengeluaran = date("Y-m-d");
            $so->jaringan_id = \app\models\Jaringan::getCurrentID();
        }
        $so->pengeluaran_part_tipe_id = $_POST["pengeluaran_part_tipe_id"];
        $so->no_referensi = $_POST["no_referensi"];
        $so->sales_id = $_POST["sales_id"];
        $so->tanggal_jatuh_tempo = $_POST["tanggal_jatuh_tempo"];
        $so->konsumen_id = $_POST["konsumen_id"];
        $so->konsumen_nama = $_POST["konsumen_nama"];
        $so->konsumen_alamat = $_POST["konsumen_alamat"];
        $so->konsumen_kota = $_POST["konsumen_kota"];
        $so->status_nsc_id = $_POST["status_nsc_id"];
        $so->catatan = $_POST["catatan"];
        $so->save();
        return \app\components\AjaxResponse::send($so);
    }
    public function actionSaveDetail($id = NULL)
    {
        $message = "Suku cadang berhasil disimpan.";
        $pengeluaran = null;
        if ($id != null) {
            $so = \app\models\PengeluaranPartDetail::find()->where(array("id" => $id))->one();
        } else {
            $so = new \app\models\PengeluaranPartDetail();
            $so->jaringan_id = \app\models\Jaringan::getCurrentID();
            $so->pengeluaran_part_id = $_POST["pengeluaran_part_id"];
        }
        $so->rak_id = $_POST["rak_id"];
        $so->suku_cadang_id = $_POST["suku_cadang_id"];
        $so->harga_jual = $_POST["harga_jual"];
        $so->hpp = $_POST["hpp"];
        $so->quantity = $_POST["quantity"];
        $so->diskon_p = $_POST["diskon_p"];
        $so->diskon_r = $_POST["diskon_r"];
        $so->total = $_POST["total"];
        $so->beban_pembayaran_id = $_POST["beban_pembayaran_id"];
        if ($so->save()) {
            $pengeluaran = $so->pengeluaranPart;
            $pengeluaran->kalkulasiTotal();
            $pengeluaran->save();
        }
        $stokKosong = false;
        $sukuCadang = \app\models\SukuCadang::find()->where(array("id" => $so->suku_cadang_id))->one();
        $sukuCadangJaringan = $sukuCadang->sukuCadangJaringan;
        if ($sukuCadangJaringan != null) {
            if ($sukuCadangJaringan->quantity <= 0) {
                $stokKosong = true;
            }
        } else {
            $stokKosong = true;
        }
        if ($stokKosong) {
            $message = "Stok barang '" . $sukuCadang->nama . "' kosong, otomatis memasukkan ke dalam stok barang kosong.";
            $kosong = \app\models\SukuCadangKosong::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "suku_cadang_id" => $so->suku_cadang_id))->one();
            if ($kosong == null) {
                $kosong = new \app\models\SukuCadangKosong();
                $kosong->jaringan_id = \app\models\Jaringan::getCurrentID();
                $kosong->suku_cadang_id = $so->suku_cadang_id;
                $kosong->jumlah = 0;
            }
            $kosong->jumlah += $so->quantity;
            $kosong->save();
            $so->delete();
        }
        return \app\components\AjaxResponse::send($pengeluaran, $message);
    }
    public function actionListDetailPengeluaranRetail($id = NULL)
    {
        if ($id != null) {
            $query = \app\models\PengeluaranPartDetail::find()->where(array("pengeluaran_part_id" => $id));
            return \app\components\DataGridUtility::process($query);
        }
        $query = \app\models\PengeluaranPartDetail::find()->where(array("id" => null));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionDeleteDetail($id)
    {
        $detail = \app\models\PengeluaranPartDetail::find()->where(array("id" => $id))->one();
        $detail->delete();
        return \app\components\AjaxResponse::send($detail, "Detail berhasil dihapus");
    }
    public function actionMarkComplete($id)
    {
        $model = \app\models\PengeluaranPart::find()->where(array("id" => $id))->one();
        $model->status_nsc_id = \app\models\StatusNsc::CLOSE;
        $model->save();
    }
    public function actionLoad($id)
    {
        return \yii\helpers\Json::encode(\app\models\PengeluaranPart::find()->where(array("id" => $id))->one());
    }
    public function actionBayar($id)
    {
        $model = \app\models\PengeluaranPart::find()->where(array("id" => $id))->one();
        $model->tunai_nominal = intval($_POST["tunai"]);
        $model->debit_nominal = intval($_POST["debit"]);
        $model->debit_terminal = $_POST["terminal"];
        $model->debit_bank = $_POST["bank"];
        $model->debit_no_kartu = $_POST["no_kartu"];
        $model->debit_pemilik = $_POST["pemilik"];
        $model->debit_approval_code = $_POST["approval_code"];
        if ($model->total <= $model->tunai_nominal + $model->debit_nominal) {
            $this->prosesPascaPenerimaan($model);
            $model->status_pembayaran_id = \app\models\StatusPembayaran::CLOSE;
        }
        $model->save();
        return \app\components\AjaxResponse::send($model, "Pembayaran berhasil dilakukan");
    }
    public function actionCetakNota($id)
    {
        \Yii::$app->response->format = "pdf";
        $pengeluaran = \app\models\PengeluaranPart::find()->where(array("id" => $id))->one();
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 25, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNsc()));
        return $this->renderPartial("cetak-nota", array("model" => $pengeluaran));
    }
    private function getHeaderNsc()
    {
        $jaringan = \app\models\Jaringan::find()->where(array("id" => \app\models\Jaringan::getCurrentID()))->one();
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>NOTA SUKU CADANG</h2>" . "</td></tr></table>";
    }
    public function actionPickingSlip($id)
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 25, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderPickingSlip()));
        return $this->renderPartial("picking-slip", array("model" => \app\models\PengeluaranPart::find()->where(array("id" => $id))->one()));
    }
    private function getHeaderPickingSlip()
    {
        $jaringan = \app\models\Jaringan::find()->where(array("id" => \app\models\Jaringan::getCurrentID()))->one();
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>PICKING SLIP</h2>" . "</td></tr></table>";
    }
    public function prosesPascaPenerimaan($pengeluaran)
    {
        if ($pengeluaran->status_nsc_id == \app\models\StatusNsc::ENTRY) {
            $harga = 0;
            foreach ($pengeluaran->pengeluaranPartDetails as $detail) {
                $sc = $detail->sukuCadang->getSukuCadangJaringan();
                if ($sc != null) {
                    $sc->quantity -= $detail->quantity;
                    $sc->save();
                }
            }
            $pengeluaran->status_nsc_id = \app\models\StatusNsc::CLOSE;
        }
    }
}

?>