<?php

namespace app\models;

class PurchaseOrder extends base\PurchaseOrder
{
    public static function getCurrentSentData()
    {
        $user = \Yii::$app->user->identity;
        return static::find()->where(array("purchase_order_status_id" => array(PurchaseOrderStatus::SENT, PurchaseOrderStatus::CLOSE), "status" => 1, "jaringan_id" => $user->jaringan_id))->all();
    }
    public function getNomorSupplier()
    {
        return $this->nomor . " - " . $this->supplier->nama;
    }
    public function fields()
    {
        return array("id", "kode" => function ($model) {
            return date("Ymd", strtotime($model->tanggal_pembuatan)) . "PO";
        }, "nomor", "tanggal_pembuatan", "tanggal_pembuatan_format" => function ($model) {
            return \app\components\Tanggal::reverse($model->tanggal_pembuatan);
        }, "purchase_order_tipe_id", "supplier_id", "supplier_nama" => function ($model) {
            return $model->supplier->nama;
        }, "purchase_order_status_id", "purchase_order_status_nama" => function ($model) {
            return $model->purchaseOrderStatus->nama;
        }, "action" => function ($model) {
            if ($model->purchase_order_status_id == 1) {
                return \yii\helpers\Html::a("Kirim ke Supplier", "#", array("class" => "easyui-linkbutton send-to-supplier", "data_id" => $model->id));
            }
            return \yii\helpers\Html::a("Force Close", "#", array("class" => "easyui-linkbutton force-close-po", "data_id" => $model->id));
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