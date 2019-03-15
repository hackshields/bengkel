<?php

namespace app\models\base;

class PenerimaanPart extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "penerimaan_part";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "no_spg", "no_faktur", "supplier_id", "tanggal_faktur", "tanggal_penerimaan", "total"), "required"), array(array("jaringan_id", "supplier_id", "purchase_order_id", "penerimaan_part_tipe_id", "pembayaran_id", "status_spg_id", "total", "status_hutang_id", "approved_by", "status", "created_by", "updated_by"), "integer"), array(array("tanggal_faktur", "tanggal_penerimaan", "tanggal_jatuh_tempo", "tanggal_retur", "tanggal_bayar", "created_at", "updated_at"), "safe"), array(array("keterangan_retur"), "string"), array(array("no_spg", "no_faktur", "no_retur"), "string", "max" => 50), array(array("bank_bayar", "bukti_bayar"), "string", "max" => 30));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "no_spg" => "No Spg", "no_faktur" => "No Faktur", "supplier_id" => "Supplier ID", "purchase_order_id" => "Purchase Order ID", "tanggal_faktur" => "Tanggal Faktur", "tanggal_penerimaan" => "Tanggal Penerimaan", "penerimaan_part_tipe_id" => "Penerimaan Part Tipe ID", "pembayaran_id" => "Pembayaran ID", "tanggal_jatuh_tempo" => "Tanggal Jatuh Tempo", "status_spg_id" => "Status Spg ID", "total" => "Total", "no_retur" => "No Retur", "tanggal_retur" => "Tanggal Retur", "keterangan_retur" => "Keterangan Retur", "status_hutang_id" => "Status Hutang ID", "approved_by" => "Approved By", "bank_bayar" => "Bank Bayar", "bukti_bayar" => "Bukti Bayar", "tanggal_bayar" => "Tanggal Bayar", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getStatusSpg()
    {
        return $this->hasOne(\app\models\StatusSpg::className(), array("id" => "status_spg_id"));
    }
    public function getStatusHutang()
    {
        return $this->hasOne(\app\models\StatusHutang::className(), array("id" => "status_hutang_id"));
    }
    public function getSupplier()
    {
        return $this->hasOne(\app\models\Supplier::className(), array("id" => "supplier_id"));
    }
    public function getPurchaseOrder()
    {
        return $this->hasOne(\app\models\PurchaseOrder::className(), array("id" => "purchase_order_id"));
    }
    public function getApprovedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "approved_by"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getPurchaseOrder0()
    {
        return $this->hasOne(\app\models\PurchaseOrder::className(), array("id" => "purchase_order_id"));
    }
    public function getPenerimaanPartTipe()
    {
        return $this->hasOne(\app\models\PenerimaanPartTipe::className(), array("id" => "penerimaan_part_tipe_id"));
    }
    public function getPembayaran()
    {
        return $this->hasOne(\app\models\Pembayaran::className(), array("id" => "pembayaran_id"));
    }
    public function getPenerimaanPartDetails()
    {
        return $this->hasMany(\app\models\PenerimaanPartDetail::className(), array("penerimaan_part_id" => "id"));
    }
}

?>