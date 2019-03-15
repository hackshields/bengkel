<?php

namespace app\models\base;

class CheckpointGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "checkpoint_group";
    }
    public function rules()
    {
        return array(array(array("checkpoint_id", "kode"), "required"), array(array("checkpoint_id", "pilih", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 5));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "checkpoint_id" => "Checkpoint", "kode" => "Kode", "pilih" => "Pilih", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getCheckpoint()
    {
        return $this->hasOne(\app\models\Checkpoint::className(), array("id" => "checkpoint_id"));
    }
}

?>