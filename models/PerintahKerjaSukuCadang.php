<?php

namespace app\models;

class PerintahKerjaSukuCadang extends base\PerintahKerjaSukuCadang
{
    public function fields()
    {
        return array("id", "suku_cadang_id", "suku_cadang_kode" => function ($model) {
            return $model->sukuCadang->kode;
        }, "suku_cadang_nama" => function ($model) {
            return $model->sukuCadang->nama;
        }, "rak_id", "rak_nama" => function ($model) {
            return $model->rak->nama;
        }, "quantity", "hpp", "harga", "diskon_p", "diskon_r", "total", "beban_pembayaran_id", "beban_pembayaran_nama" => function ($model) {
            return $model->bebanPembayaran->nama;
        }, "tanggal" => function ($model) {
            return \app\components\Tanggal::toReadableDate($model->perintahKerja->waktu_daftar, false, true);
        }, "action_delete" => function ($model) {
            return \yii\helpers\Html::button("Edit", array("class" => "btn-edit-sukucadang", "data_id" => $model->id)) . " " . \yii\helpers\Html::button("Hapus", array("class" => "btn-hapus-sukucadang", "data_id" => $model->id));
        });
    }
    public function beforeSave($insert)
    {
        if ($this->beban_pembayaran_id == BebanPembayaran::CASH) {
            $h = $this->harga * $this->quantity;
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
}

?>