<?php

namespace app\models\base;

class PurchaseOrder extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "purchase_order";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "nomor", "purchase_order_tipe_id", "tanggal_pembuatan"), "required"), array(array("jaringan_id", "purchase_order_tipe_id", "supplier_id", "purchase_order_status_id", "status", "created_by", "updated_by"), "integer"), array(array("tanggal_pembuatan", "tanggal_kirim", "tanggal_pemenuhan", "created_at", "updated_at"), "safe"), array(array("nomor"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "nomor" => "Nomor", "purchase_order_tipe_id" => "Purchase Order Tipe ID", "tanggal_pembuatan" => "Tanggal Pembuatan", "tanggal_kirim" => "Tanggal Kirim", "tanggal_pemenuhan" => "Tanggal Pemenuhan", "supplier_id" => "Supplier ID", "purchase_order_status_id" => "Purchase Order Status ID", "status" => "Status", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getPenerimaanParts()
    {
        return $this->hasMany(\app\models\PenerimaanPart::className(), array("purchase_order_id" => "id"));
    }
    public function getPenerimaanParts0()
    {
        return $this->hasMany(\app\models\PenerimaanPart::className(), array("purchase_order_id" => "id"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getSupplier()
    {
        return $this->hasOne(\app\models\Supplier::className(), array("id" => "supplier_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getPurchaseOrderTipe()
    {
        return $this->hasOne(\app\models\PurchaseOrderTipe::className(), array("id" => "purchase_order_tipe_id"));
    }
    public function getPurchaseOrderStatus()
    {
        return $this->hasOne(\app\models\PurchaseOrderStatus::className(), array("id" => "purchase_order_status_id"));
    }
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(\app\models\PurchaseOrderDetail::className(), array("purchase_order_id" => "id"));
    }
}

?>