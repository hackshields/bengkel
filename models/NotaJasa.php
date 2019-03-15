<?php

namespace app\models;

class NotaJasa extends base\NotaJasa
{
    public function generateNomorNota()
    {
        $max = NotaJasa::find()->select("max(id) as id")->one();
        $jml = NotaJasa::find()->where(array("year(tanggal_njb)" => date("Y"), "month(tanggal_njb)" => date("n")))->count();
        $this->nomor = date("Ymd") . ($max + 1) . "NJB" . str_pad($jml + 1, 3, "0", STR_PAD_LEFT);
    }
    public function kalkulasiTotal()
    {
        $harga = 0;
        foreach ($this->notaJasaDetails as $detail) {
            $harga += $detail->total;
        }
        $this->total = $harga;
    }
    public static function getCurrentActive()
    {
        return NotaJasa::find()->where(array("jaringan_id" => Jaringan::getCurrentID()))->all();
    }
    public function fields()
    {
        return array("id", "nomor", "perintah_kerja_id", "karyawan_id", "karyawan_nama" => function ($model) {
            return $model->karyawan->name;
        }, "tanggal_njb", "tanggal_njb_format" => function ($model) {
            return \app\components\Tanggal::toReadableDate($model->tanggal_njb, false, true);
        }, "tanggal_jt", "konsumen_nama" => function ($model) {
            return $model->perintahKerja->konsumen->nama_identitas;
        }, "konsumen_alamat" => function ($model) {
            return $model->perintahKerja->konsumen->alamat;
        }, "konsumen_kota" => function ($model) {
            return $model->perintahKerja->konsumen->wilayahKabupaten->nama;
        }, "konsumen_nopol" => function ($model) {
            return $model->perintahKerja->konsumen->nopol;
        }, "catatan", "nomor_cetak", "status_njb_id", "status_njb_nama" => function ($model) {
            return $model->statusNjb->nama;
        }, "total", "no_batal", "tanggal_batal", "approved_by", "status_pembayaran_id", "status_pembayaran_nama" => function ($model) {
            return $model->statusPembayaran->nama;
        }, "tanggal_bayar", "bukti_bayar", "bank_bayar", "no_pkb" => function ($model) {
            return $model->perintahKerja->nomor;
        }, "nopol" => function ($model) {
            return $model->perintahKerja->konsumen->nopol;
        }, "perintahKerja");
    }
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = self::find()->where(array("nomor" => $kode, "jaringan_id" => Jaringan::getCurrentID()))->one();
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