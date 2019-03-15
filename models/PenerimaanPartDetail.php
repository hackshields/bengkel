<?php

namespace app\models;

class PenerimaanPartDetail extends base\PenerimaanPartDetail
{
    public function fields()
    {
        return array("id", "penerimaan_part_id", "suku_cadang_id", "suku_cadang_kode" => function ($model) {
            return $model->sukuCadang->kode;
        }, "suku_cadang_nama" => function ($model) {
            return $model->sukuCadang->nama;
        }, "harga_beli", "quantity_order", "quantity_supp", "diskon_p", "diskon_r", "rak_id", "rak_nama" => function ($model) {
            return $model->rak->nama;
        }, "total_harga", "action" => function ($model) {
            return \yii\helpers\Html::button("Hapus", array("class" => "btn-delete-detail-penerimaan", "data_id" => $model->id));
        });
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
        $total = 0;
        $penerimaanPart = $this->penerimaanPart;
        foreach ($penerimaanPart->penerimaanPartDetails as $detail) {
            $h = $detail->harga_beli * $detail->quantity_supp;
            if ($this->diskon_p != 0) {
                $h -= $this->diskon_p / 100 * $h;
            }
            if ($this->diskon_r != 0) {
                $h -= $this->diskon_r;
            }
            $total += $h;
        }
        $penerimaanPart->total = $total;
        $penerimaanPart->save();
    }
}

?>