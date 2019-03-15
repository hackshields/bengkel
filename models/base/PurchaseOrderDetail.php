<?php

namespace app\models\base;

class PurchaseOrderDetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "purchase_order_detail";
    }
    public function rules()
    {
        return array(array(array("purchase_order_id", "suku_cadang_id"), "required"), array(array("purchase_order_id", "suku_cadang_id", "jaringan_id", "quantity_order", "quantity_supp", "quantity_back_order", "tanggal_supp", "created_by", "updated_by", "online_id", "is_need_update"), "integer"), array(array("created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "purchase_order_id" => "Purchase Order ID", "suku_cadang_id" => "Suku Cadang ID", "jaringan_id" => "Jaringan ID", "quantity_order" => "Quantity Order", "quantity_supp" => "Quantity Supp", "quantity_back_order" => "Quantity Back Order", "tanggal_supp" => "Tanggal Supp", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By", "online_id" => "Online ID", "is_need_update" => "Is Need Update");
    }
    public function getPurchaseOrder()
    {
        return $this->hasOne(\app\models\PurchaseOrder::className(), array("id" => "purchase_order_id"));
    }
    public function getSukuCadang()
    {
        return $this->hasOne(\app\models\SukuCadang::className(), array("id" => "suku_cadang_id"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
}

?>