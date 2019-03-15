<?php

namespace app\models;

class PenerimaanPart extends base\PenerimaanPart
{
    public function fields()
    {
        return array("id", "no_spg", "no_faktur", "tanggal_penerimaan", "tanggal_penerimaan_format" => function ($model) {
            return \app\components\Tanggal::toReadableDate($model->tanggal_penerimaan, false);
        }, "tanggal_faktur", "tanggal_faktur_format" => function ($model) {
            return \app\components\Tanggal::toReadableDate($model->tanggal_penerimaan, false);
        }, "supplier_id", "supplier_nama" => function ($model) {
            return $model->supplier->nama;
        }, "supplier", "total", "total_formatted" => function ($model) {
            return \app\components\Angka::toReadableHarga($model->total, false);
        }, "purchase_order_id", "jaringan_id", "purchase_order_id", "penerimaan_part_tipe_id", "pembayaran_id", "tanggal_jatuh_tempo", "status_spg_id", "no_retur", "tanggal_retur", "keterangan_retur", "status_hutang_id", "approved_by", "bank_bayar", "bukti_bayar", "tanggal_bayar");
    }
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = self::find()->where(array("no_spg" => $kode, "jaringan_id" => Jaringan::getCurrentID()))->one();
        if ($kGroup) {
            return $kGroup->id;
        }
        return null;
    }
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
            $this->created_by = \Yii::$app->user->id;
        } else {
            $this->updated_at = date("Y-m-d H:i:s");
            $this->updated_by = \Yii::$app->user->id;
        }
        $this->is_need_update = 1;
        if (\Yii::$app->user->isGuest) {
            BreachLog::addLog();
            return false;
        }
        return true;
    }
}

?>