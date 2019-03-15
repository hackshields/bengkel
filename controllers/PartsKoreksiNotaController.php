<?php

namespace app\controllers;

class PartsKoreksiNotaController extends \yii\web\Controller
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
    public function actionUpdate($id, $keterangan, $pengeluaran_part_tipe_id, $sales_id, $user_id, $user_password)
    {
        $user = \app\models\User::find()->where(array("id" => $user_id, "password" => md5($user_password)))->one();
        $pengeluaran = \app\models\PengeluaranPart::find()->where(array("id" => $id))->one();
        if ($user != null) {
            $pengeluaran->{$pengeluaran_part_tipe_id} = $pengeluaran_part_tipe_id;
            $pengeluaran->sales_id = $sales_id;
            $pengeluaran->save();
            $message = "Update Berhasil.";
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
    public function actionUpdateDetailPembayaran($id, $beban_pembayaran_id)
    {
        $detail = \app\models\PengeluaranPartDetail::find()->where(array("id" => $id))->one();
        $detail->beban_pembayaran_id = $beban_pembayaran_id;
        $detail->save();
        return \app\components\AjaxResponse::send($detail);
    }
}

?>