<?php

namespace app\controllers;

class PartsReturPenjualanController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionLoad($id)
    {
        $pengeluaran = \app\models\PengeluaranPart::find()->where(array("id" => $id))->one();
        return \yii\helpers\Json::encode(array("status" => "OK", "data" => $pengeluaran));
    }
    public function actionProsesBatal($id, $keterangan, $user_id, $user_password)
    {
        $user = \app\models\User::find()->where(array("id" => $user_id, "password" => md5($user_password)))->one();
        $pengeluaran = \app\models\PengeluaranPart::find()->where(array("id" => $id))->one();
        if ($user != null) {
            if ($pengeluaran->status_nsc_id == \app\models\StatusNsc::CLOSE) {
                $pengeluaran->status_nsc_id = \app\models\StatusNsc::BATAL;
                $pengeluaran->nomor_retur = str_replace($pengeluaran->no_nsc, "NSC", "RNSC");
                $pengeluaran->keterangan_retur = $keterangan;
                $pengeluaran->tanggal_retur = date("Y-m-d");
                $pengeluaran->save();
                foreach ($pengeluaran->pengeluaranPartDetails as $detail) {
                    $detail->sukuCadang->prosesHet();
                    $sc = $detail->sukuCadang->getSukuCadangJaringan();
                    if ($sc != null) {
                        $sc->quantity += $detail->quantity;
                        $sc->save();
                    }
                }
                $message = "Pengeluaran Berhasil Dibatalkan.";
            } else {
                $message = "Pengeluaran Sudah Dibatalkan.";
            }
        } else {
            $message = "Password Salah.";
        }
        return \app\components\AjaxResponse::send($pengeluaran, $message);
    }
    public function actionSpgCombo($id)
    {
        $output = array();
        foreach (\app\models\PengeluaranPart::find()->where(array("id" => $id))->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->no_nsc);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionListPengeluaran()
    {
        $tgl = date("Y-m-d", strtotime("now -1 day"));
        $query = \app\models\PengeluaranPart::find()->where(array("status_nsc_id" => \app\models\StatusNsc::CLOSE, "jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("tanggal_pengeluaran > '" . $tgl . "'");
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListDetailPengeluaran($id = NULL)
    {
        $query = \app\models\PengeluaranPartDetail::find()->where(array("pengeluaran_part_id" => $id));
        return \app\components\DataGridUtility::process($query);
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
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>RETUR SUKU CADANG</h2>" . "</td></tr></table>";
    }
}

?>