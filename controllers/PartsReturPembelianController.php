<?php

namespace app\controllers;

class PartsReturPembelianController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionLoad($id)
    {
        $penerimaan = \app\models\PenerimaanPart::find()->where(array("id" => $id))->one();
        return \yii\helpers\Json::encode(array("status" => "OK", "data" => $penerimaan));
    }
    public function actionProsesBatal($id, $keterangan, $user_id, $user_password)
    {
        $user = \app\models\User::find()->where(array("id" => $user_id, "password" => md5($user_password)))->one();
        $penerimaan = \app\models\PenerimaanPart::find()->where(array("id" => $id))->one();
        if ($user != null) {
            if ($penerimaan->status_spg_id == \app\models\StatusSpg::CLOSE) {
                $penerimaan->status_spg_id = \app\models\StatusSpg::BATAL;
                $penerimaan->no_retur = str_replace($penerimaan->no_spg, "SPG", "RSPG");
                $penerimaan->keterangan_retur = $keterangan;
                $penerimaan->tanggal_retur = date("Y-m-d");
                $penerimaan->save();
                foreach ($penerimaan->penerimaanPartDetails as $detail) {
                    $detail->sukuCadang->prosesHet();
                    $sc = $detail->sukuCadang->getSukuCadangJaringan();
                    if ($sc != null) {
                        $sc->quantity -= $detail->quantity_supp;
                        $sc->save();
                    }
                }
                $message = "Penerimaan Berhasil Dibatalkan.";
            } else {
                $message = "Penerimaan Sudah Dibatalkan.";
            }
        } else {
            $message = "Password Salah.";
        }
        return \app\components\AjaxResponse::send($penerimaan, $message);
    }
    public function actionSpgCombo($id)
    {
        $output = array();
        foreach (\app\models\PenerimaanPart::find()->where(array("id" => $id))->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->no_spg);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionListPenerimaan()
    {
        $tgl = date("Y-m-d", strtotime("now -1 day"));
        $query = \app\models\PenerimaanPart::find()->where(array("status_spg_id" => \app\models\StatusSpg::CLOSE, "jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("tanggal_penerimaan > '" . $tgl . "'");
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListDetailPenerimaan($id = NULL)
    {
        $query = \app\models\PenerimaanPartDetail::find()->where(array("penerimaan_part_id" => $id));
        return \app\components\DataGridUtility::process($query);
    }
}

?>