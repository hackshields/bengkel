<?php

namespace app\models\base;

class StockOpnameDetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "stock_opname_detail";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "stock_opname_id", "suku_cadang_id"), "required"), array(array("jaringan_id", "stock_opname_id", "jumlah_recount", "rak_id", "suku_cadang_id", "quantity_oh", "quantity_sy", "created_by", "updated_by"), "integer"), array(array("keterangan"), "string"), array(array("created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "stock_opname_id" => "Stock Opname ID", "jumlah_recount" => "Jumlah Recount", "rak_id" => "Rak ID", "suku_cadang_id" => "Suku Cadang ID", "quantity_oh" => "Quantity Oh", "quantity_sy" => "Quantity Sy", "keterangan" => "Keterangan", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getStockOpname()
    {
        return $this->hasOne(\app\models\StockOpname::className(), array("id" => "stock_opname_id"));
    }
    public function getRak()
    {
        return $this->hasOne(\app\models\Rak::className(), array("id" => "rak_id"));
    }
    public function getSukuCadang()
    {
        return $this->hasOne(\app\models\SukuCadang::className(), array("id" => "suku_cadang_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
}

?>