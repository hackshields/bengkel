<?php

namespace app\models\base;

class StockOpname extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "stock_opname";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "no_opname", "tanggal_opname", "status_opname_id"), "required"), array(array("jaringan_id", "petugas_id", "status_opname_id", "status", "created_by", "updated_by"), "integer"), array(array("tanggal_opname", "tanggal_closing", "created_at", "updated_at"), "safe"), array(array("no_opname"), "string", "max" => 20));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "no_opname" => "No Opname", "tanggal_opname" => "Tanggal Opname", "tanggal_closing" => "Tanggal Closing", "petugas_id" => "Petugas ID", "status_opname_id" => "Status Opname ID", "status" => "Status", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getStatusOpname()
    {
        return $this->hasOne(\app\models\StatusOpname::className(), array("id" => "status_opname_id"));
    }
    public function getPetugas()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "petugas_id"));
    }
    public function getStockOpnameDetails()
    {
        return $this->hasMany(\app\models\StockOpnameDetail::className(), array("stock_opname_id" => "id"));
    }
    public function getStockOpnameRecounts()
    {
        return $this->hasMany(\app\models\StockOpnameRecount::className(), array("stock_opname_id" => "id"));
    }
}

?>