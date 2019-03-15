<?php

namespace app\controllers;

class AjaxController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionKabupaten($id)
    {
        $output = array();
        foreach (\app\models\WilayahKabupaten::find()->where(array("wilayah_provinsi_id" => $id))->orderBy("nama")->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nama);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionKecamatan($id)
    {
        $output = array();
        foreach (\app\models\WilayahKecamatan::find()->where(array("wilayah_kabupaten_id" => $id))->orderBy("nama")->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nama);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionDesa($id)
    {
        $output = array();
        foreach (\app\models\WilayahDesa::find()->where(array("wilayah_kecamatan_id" => $id))->orderBy("nama")->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nama);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionKodepos($id)
    {
        $desa = \app\models\WilayahDesa::find()->where(array("id" => $id))->one();
        return $desa->kodepos;
    }
    public function actionSimpanKonsumen()
    {
        $model = new \app\models\Konsumen();
        $model->jaringan_id = \app\models\Jaringan::getCurrentID();
        if ($model->load($_POST)) {
            if ($model->wilayah_propinsi_id == "") {
                $model->wilayah_propinsi_id = null;
            }
            if ($model->wilayah_kabupaten_id == "") {
                $model->wilayah_kabupaten_id = null;
            }
            if ($model->wilayah_kecamatan_id == "") {
                $model->wilayah_kecamatan_id = null;
            }
            if ($model->wilayah_desa_id == "") {
                $model->wilayah_desa_id = null;
            }
            if ($model->kode == null) {
                $model->kode = $model->nopol;
            }
            if ($model->save()) {
                return \yii\helpers\Json::encode(array("status" => \app\components\AjaxResponse::STATUS_OK, "code" => \app\components\AjaxResponse::STATUS_OK, "message" => "Konsumen berhasil ditambahkan", "data_combo" => array(array("value" => $model->id, "text" => $model->nopol . " - " . $model->nama_identitas)), "data" => $model));
            }
            return \app\components\AjaxResponse::send($model);
        }
    }
    public function actionNopolCombo($id)
    {
        $output = array();
        foreach (\app\models\Konsumen::find()->where(array("id" => $id))->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nopol . " - " . $kab->nama_identitas);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionWilayah()
    {
        $query = \app\models\ViewWilayah::find();
        return \app\components\DataGridUtility::process($query);
    }
    public function actionNoRangka($no)
    {
        $konsumen = \app\models\Konsumen::find()->where(array("no_rangka" => $no))->one();
        if ($konsumen != null) {
            return \yii\helpers\Json::encode(array("message" => "No Rangka " . $no . " sudah dipakai oleh " . $konsumen->nama_identitas));
        }
        return \yii\helpers\Json::encode(array("message" => ""));
    }
    public function actionNoMesin($no)
    {
        $konsumen = \app\models\Konsumen::find()->where(array("no_mesin" => $no))->one();
        if ($konsumen != null) {
            return \yii\helpers\Json::encode(array("message" => "No Mesin " . $no . " sudah dipakai oleh " . $konsumen->nama_identitas));
        }
        return \yii\helpers\Json::encode(array("message" => ""));
    }
}

?>