<?php

namespace app\models;

class NotaJasaDetail extends base\NotaJasaDetail
{
    public function fields()
    {
        return array("id", "jasa_id", "jasa_kode" => function ($model) {
            return $model->jasa->kode;
        }, "jasa_nama" => function ($model) {
            return $model->jasa->nama;
        }, "nama_jasa", "pkb_tanggal" => function ($model) {
            return date("Y-m-d", strtotime($model->notaJasa->perintahKerja->waktu_daftar));
        }, "pkb_km" => function ($model) {
            return $model->notaJasa->perintahKerja->km;
        }, "pkb_karyawan" => function ($model) {
            return $model->notaJasa->perintahKerja->karyawan->name;
        }, "pkb_no" => function ($model) {
            return $model->notaJasa->perintahKerja->nomor;
        }, "harga", "diskon_p", "diskon_r", "total", "dpph", "dpp", "pph", "ppn", "operasional", "beban_pembayaran_id", "beban_pembayaran_nama" => function ($model) {
            return $model->bebanPembayaran->nama;
        }, "koreksi_nota_action" => function ($model) {
            return \yii\helpers\Html::button("Edit", array("class" => "detail-edit", "data_id" => $model->id, "beban_pembayaran_id" => $model->beban_pembayaran_id));
        });
    }
    public function beforeSave($insert)
    {
        if ($this->beban_pembayaran_id == BebanPembayaran::CASH) {
            $h = $this->harga;
            if ($this->diskon_p != 0) {
                $h -= $this->diskon_p / 100 * $h;
            }
            if ($this->diskon_r != 0) {
                $h -= $this->diskon_r;
            }
            $this->total = $h;
        } else {
            $this->total = 0;
        }
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
    public function afterSave($insert, $changedAttributes)
    {
        $notaJasa = $this->notaJasa;
        $notaJasa->kalkulasiTotal();
        $notaJasa->save();
    }
}

?>