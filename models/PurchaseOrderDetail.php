<?php

namespace app\models;

class PurchaseOrderDetail extends base\PurchaseOrderDetail
{
    public function fields()
    {
        return array("id", "suku_cadang_kode" => function ($model) {
            return $model->sukuCadang->kode;
        }, "suku_cadang_nama" => function ($model) {
            return $model->sukuCadang->nama;
        }, "quantity_order", "quantity_supp", "quantity_back_order", "tanggal_supp", "action" => function ($model) {
            if ($model->purchaseOrder->purchase_order_status_id == PurchaseOrderStatus::ENTRY) {
                return \yii\helpers\Html::button("Edit", array("data_id" => $model->id, "class" => "btn-po-detail-edit", "quantity_order" => $model->quantity_order, "quantity_supp" => $model->quantity_supp, "quantity_back_order" => $model->quantity_back_order, "suku_cadang_nama" => $model->sukuCadang->nama)) . " " . \yii\helpers\Html::button("Delete", array("data_id" => $model->id, "class" => "btn-po-detail-delete", "quantity_order" => $model->quantity_order, "quantity_supp" => $model->quantity_supp, "quantity_back_order" => $model->quantity_back_order, "suku_cadang_nama" => $model->sukuCadang->nama));
            }
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
        $this->is_need_update = 1;
        if (\Yii::$app->user->isGuest) {
            BreachLog::addLog();
            return false;
        }
        return true;
    }
}

?>