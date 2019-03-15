<?php

namespace app\models;

class PengeluaranPart extends base\PengeluaranPart
{
    public function generateNomorNota()
    {
        $max = PengeluaranPart::find()->select("max(id) as id")->one();
        $jml = PengeluaranPart::find()->where(array("year(tanggal_pengeluaran)" => date("Y"), "month(tanggal_pengeluaran)" => date("n")))->count();
        $this->no_nsc = date("mY") . ($max + 1) . "NSC" . str_pad($jml + 1, 3, "0", STR_PAD_LEFT);
    }
    public function fields()
    {
        return array("id", "jaringan_id", "no_nsc", "pengeluaran_part_tipe_id", "pengeluaran_part_tipe_nama" => function ($model) {
            return $model->pengeluaranPartTipe->nama;
        }, "no_referensi", "no_pkb" => function ($model) {
            if ($model->noReferensi) {
                return $model->noReferensi->nomor;
            }
            return "";
        }, "sales_id", "tanggal_pengeluaran", "tanggal_pengeluaran_format" => function ($model) {
            return \app\components\Tanggal::toReadableDate($model->tanggal_pengeluaran, false);
        }, "tanggal_jatuh_tempo", "konsumen_id", "konsumen_nama", "konsumen_alamat", "konsumen_kota", "nomor_cetak", "catatan", "status_nsc_id", "status_nsc_nama" => function ($model) {
            return $model->statusNsc->nama;
        }, "keterangan_retur", "tanggal_retur", "approved_by", "nomor_retur", "status_pembayaran_id", "total", "total_formatted" => function ($model) {
            return \app\components\Angka::toReadableHarga($model->total, false);
        }, "bukti_bayar_reguler", "tanggal_bayar_reguler", "konsumen_penerima_id", "bank_bayar_reguler");
    }
    public function kalkulasiTotal()
    {
        $harga = 0;
        foreach ($this->pengeluaranPartDetails as $detail) {
            $harga += $detail->total;
        }
        $this->total = $harga;
    }
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = self::find()->where(array("no_nsc" => $kode, "jaringan_id" => Jaringan::getCurrentID()))->one();
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