<?php

namespace app\models\base;

class Kpb extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "kpb";
    }
    public function rules()
    {
        return array(array(array("kode", "nama"), "required"), array(array("harga_ass_1", "harga_ass_2", "harga_ass_3", "harga_ass_4", "harga_oli", "status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 15), array(array("nama"), "string", "max" => 30));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "kode" => "Kode", "nama" => "Nama", "harga_ass_1" => "Harga Ass #1", "harga_ass_2" => "Harga Ass #2", "harga_ass_3" => "Harga Ass #3", "harga_ass_4" => "Harga Ass #4", "harga_oli" => "Harga Oli", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
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