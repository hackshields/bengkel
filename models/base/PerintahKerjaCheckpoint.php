<?php

namespace app\models\base;

class PerintahKerjaCheckpoint extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "perintah_kerja_checkpoint";
    }
    public function rules()
    {
        return array(array(array("perintah_kerja_id", "checkpoint_item_id"), "required"), array(array("perintah_kerja_id", "checkpoint_item_id", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "perintah_kerja_id" => "Perintah Kerja ID", "checkpoint_item_id" => "Checkpoint Item ID", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getPerintahKerja()
    {
        return $this->hasOne(\app\models\PerintahKerja::className(), array("id" => "perintah_kerja_id"));
    }
    public function getCheckpointItem()
    {
        return $this->hasOne(\app\models\CheckpointItem::className(), array("id" => "checkpoint_item_id"));
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