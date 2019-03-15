<?php

namespace app\models;

class Setting extends base\Setting
{
    public static function isSyncDone()
    {
        $model = Setting::find()->where(array("key" => "SYNC_DONE"))->one();
        if ($model && $model->value == 1) {
            return true;
        }
        return false;
    }
    public static function setSyncDone()
    {
        $model = Setting::find()->where(array("key" => "SYNC_DONE"))->one();
        if ($model == null) {
            $model = new Setting();
            $model->key = "SYNC_DONE";
        }
        $model->value = 1;
        $model->save();
    }
    public static function getUpdateTime()
    {
        $model = Setting::find()->where(array("key" => "SERVER_UPDATE_TIME"))->one();
        if ($model) {
            return $model->value;
        }
        return "2017-05-05";
    }
    public static function setUpdateTime($time)
    {
        $model = Setting::find()->where(array("key" => "SERVER_UPDATE_TIME"))->one();
        if ($model == null) {
            $model = new Setting();
            $model->key = "SERVER_UPDATE_TIME";
        }
        $model->value = $time;
        $model->save();
    }
    public static function getMigrationVersion()
    {
        $model = Setting::find()->where(array("key" => "MIGRATION_VERSION"))->one();
        if ($model) {
            return $model->value;
        }
        return "1";
    }
    public static function upMigrationVersion()
    {
        $model = Setting::find()->where(array("key" => "MIGRATION_VERSION"))->one();
        if ($model == null) {
            $model = new Setting();
            $model->key = "MIGRATION_VERSION";
        }
        $model->value = self::getMigrationVersion() + 1;
        $model->save();
    }
    public static function setMigrationVersion($val)
    {
        $model = Setting::find()->where(array("key" => "MIGRATION_VERSION"))->one();
        if ($model == null) {
            $model = new Setting();
            $model->key = "MIGRATION_VERSION";
        }
        $model->value = $val;
        $model->save();
    }
}

?>