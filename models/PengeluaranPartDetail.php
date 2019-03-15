<?php

namespace app\models;

class PengeluaranPartDetail extends base\PengeluaranPartDetail
{
    public function fields()
    {
        return array("id", "suku_cadang_id", "suku_cadang_kode" => function ($model) {
            return $model->sukuCadang->kode;
        }, "suku_cadang_nama" => function ($model) {
            return $model->sukuCadang->nama;
        }, "suku_cadang_nama_sinonim" => function ($model) {
            return $model->sukuCadang->nama_sinonim;
        }, "rak_id", "rak_nama" => function ($model) {
            return $model->rak->nama;
        }, "pkb_tanggal" => function ($model) {
            return date("Y-m-d", strtotime($model->pengeluaranPart->tanggal_pengeluaran));
        }, "pkb_km" => function ($model) {
            if ($model->pengeluaranPart->noReferensi) {
                return $model->pengeluaranPart->noReferensi->km;
            }
            return "-";
        }, "pkb_karyawan" => function ($model) {
            if ($model->pengeluaranPart->noReferensi) {
                return $model->pengeluaranPart->noReferensi->karyawan->name;
            }
            return "-";
        }, "pkb_no" => function ($model) {
            if ($model->pengeluaranPart->noReferensi) {
                return $model->pengeluaranPart->noReferensi->nomor;
            }
            return "-";
        }, "het", "hpp", "quantity", "diskon_p", "diskon_r", "total", "beban_pembayaran_id", "beban_pembayaran_nama" => function ($model) {
            return $model->bebanPembayaran->nama;
        }, "tanggal" => function ($model) {
            return $model->pengeluaranPart->tanggal_pengeluaran;
        }, "koreksi_nota_action" => function ($model) {
            return \yii\helpers\Html::button("Edit", array("class" => "detail-edit", "data_id" => $model->id, "beban_pembayaran_id" => $model->beban_pembayaran_id));
        });
    }
    public function getDiskon()
    {
        $diskon = 0;
        $h = $this->het * $this->quantity;
        if ($this->diskon_p != 0) {
            $diskon = $this->diskon_p / 100 * $h;
        }
        if ($this->diskon_r != 0) {
            $diskon = $this->diskon_r;
        }
        return $diskon;
    }
    public function beforeSave($insert)
    {
        if ($this->beban_pembayaran_id == BebanPembayaran::CASH) {
            $h = $this->het * $this->quantity;
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
        if ($this->rak_id == null) {
            $this->rak_id = Jaringan::getDefaultRakID();
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
        $pengeluaranPart = $this->pengeluaranPart;
        $pengeluaranPart->kalkulasiTotal();
        $pengeluaranPart->save();
    }
}

?>