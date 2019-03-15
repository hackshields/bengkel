<?php

namespace app\controllers;

class BengkelNotaJasaController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionListNotaJasa()
    {
        $query = \app\models\NotaJasa::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "date(tanggal_njb)" => date("Y-m-d"), "status_njb_id" => \app\models\StatusNjb::ENTRY));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListPkb()
    {
        $query = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => array(\app\models\PerintahKerjaStatus::SELESAI, \app\models\PerintahKerjaStatus::NOTA), "date(waktu_daftar)" => date("Y-m-d")));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionNopkbCombo($id)
    {
        $output = array();
        foreach (\app\models\PerintahKerja::find()->where(array("id" => $id))->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nomor);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionAddNotaJasa()
    {
        if ($_POST["perintah_kerja_id"] == null) {
            $pen = new \app\models\NotaJasa();
            $pen->addError("perintah_kerja_id", "No PKB harus dipilih");
            return \app\components\AjaxResponse::send($pen, "Nota Jasa Berhasil ditambahkan");
        }
        $user = \Yii::$app->user->identity;
        $pen = new \app\models\NotaJasa();
        $pen->jaringan_id = $user->jaringan_id;
        $pen->generateNomorNota();
        $pen->karyawan_id = $user->id;
        $pen->tanggal_njb = date("Y-m-d H:i:s");
        $pen->tanggal_jt = $_POST["tanggal_jt"];
        $pen->perintah_kerja_id = $_POST["perintah_kerja_id"];
        $pen->catatan = $_POST["catatan"];
        $pen->status_njb_id = 1;
        $pen->status_pembayaran_id = $_POST["status_pembayaran_id"];
        $pen->save();
        return \app\components\AjaxResponse::send($pen, "Nota Jasa Berhasil ditambahkan");
    }
    public function actionListAllJasa()
    {
        $query = \app\models\Jasa::find()->where(array("jaringan_id" => \Yii::$app->user->identity->jaringan_id, "status" => 1));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionDelete($id)
    {
        $model = \app\models\NotaJasa::find()->where(array("id" => $id))->one();
        foreach ($model->notaJasaDetails as $detail) {
            $detail->delete();
        }
        $model->delete();
        return \app\components\AjaxResponse::send($model);
    }
    public function actionDetailNotaJasa($id = NULL)
    {
        $query = \app\models\NotaJasaDetail::find()->where(array("nota_jasa_id" => $id));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionAddDetailNotaJasa()
    {
        $jasa = \app\models\Jasa::find()->where(array("id" => $_POST["jasa_id"]))->one();
        $pen = new \app\models\NotaJasaDetail();
        $pen->jaringan_id = \app\models\Jaringan::getCurrentID();
        $pen->jasa_id = $jasa->id;
        $pen->nota_jasa_id = $_POST["nota_jasa_id"];
        $pen->nama_jasa = $jasa->nama;
        $pen->harga = $jasa->harga;
        $pen->total = $jasa->harga;
        $pen->dpph = 0;
        $pen->dpp = 0;
        $pen->pph = 0;
        $pen->ppn = 0;
        $pen->operasional = $jasa->operasional;
        $pen->beban_pembayaran_id = $_POST["beban_pembayaran_id"];
        if ($pen->save()) {
            $njb = $pen->notaJasa;
            $njb->kalkulasiTotal();
            $njb->save();
        }
        return \app\components\AjaxResponse::send($pen);
    }
    public function actionLoadNjb($id)
    {
        return \yii\helpers\Json::encode(\app\models\NotaJasa::find()->where(array("id" => $id))->one());
    }
    public function actionBayar($id)
    {
        $model = \app\models\NotaJasa::find()->where(array("id" => $id))->one();
        $model->tunai_nominal = $_POST["tunai"];
        $model->debit_nominal = $_POST["debit"];
        $model->debit_terminal = $_POST["terminal"];
        $model->debit_bank = $_POST["bank"];
        $model->debit_no_kartu = $_POST["no_kartu"];
        $model->debit_pemilik = $_POST["pemilik"];
        $model->debit_approval_code = $_POST["approval_code"];
        if ($model->total <= $model->tunai_nominal + $model->debit_nominal) {
            $model->status_pembayaran_id = \app\models\StatusPembayaran::CLOSE;
            $model->status_njb_id = \app\models\StatusNjb::CLOSE;
        }
        $model->save();
        return \app\components\AjaxResponse::send($model, "Pembayaran berhasil dilakukan");
    }
    public function actionCetakNota($id)
    {
        \Yii::$app->response->format = "pdf";
        $notaJasa = \app\models\NotaJasa::find()->where(array("id" => $id))->one();
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 20, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("NOTA JASA BENGKEL")));
        return $this->renderPartial("cetak-nota", array("model" => $notaJasa));
    }
    private function getHeaderNota($label)
    {
        $jaringan = \app\models\Jaringan::find()->where(array("id" => \app\models\Jaringan::getCurrentID()))->one();
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>" . $label . "</h2>" . "</td></tr></table>";
    }
}

?>