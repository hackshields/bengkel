<?php

namespace app\models\base;

class SukuCadangKosong extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "suku_cadang_kosong";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "suku_cadang_id", "jumlah"), "required"), array(array("jaringan_id", "suku_cadang_id", "jumlah", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "suku_cadang_id" => "Suku Cadang ID", "jumlah" => "Jumlah", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
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
}

?>