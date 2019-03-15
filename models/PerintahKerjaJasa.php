<?php

namespace app\models;

class PerintahKerjaJasa extends base\PerintahKerjaJasa
{
    public function fields()
    {
        return array("id", "jasa_id", "jasa_kode" => function ($model) {
            return $model->jasa->kode;
        }, "jasa_nama" => function ($model) {
            return $model->jasa->nama;
        }, "quantity" => function ($model) {
            return 1;
        }, "harga", "diskon_p", "diskon_r", "total", "dpph", "dpp", "pph", "ppn", "operasional", "beban_pembayaran_id", "beban_pembayaran_nama" => function ($model) {
            return $model->bebanPembayaran->nama;
        }, "tanggal" => function ($model) {
            return \app\components\Tanggal::toReadableDate($model->perintahKerja->waktu_daftar, false, true);
        }, "action_delete" => function ($model) {
            return \yii\helpers\Html::button("Edit", array("class" => "btn-edit-jasa", "data_id" => $model->id)) . " " . \yii\helpers\Html::button("Hapus", array("class" => "btn-hapus-jasa", "data_id" => $model->id));
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
}

?>