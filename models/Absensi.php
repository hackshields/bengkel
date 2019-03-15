<?php

namespace app\models;

class Absensi extends base\Absensi
{
    public function fields()
    {
        return array("id", "tanggal" => function ($model) {
            return \app\components\Tanggal::toReadableDate($model->jam_masuk, false, true);
        }, "karyawan_id", "karyawan_nama" => function ($model) {
            return $model->karyawan->name;
        }, "absensi_status_id", "absensiStatus", "keterangan", "jam_masuk" => function ($model) {
            if ($model->jam_masuk == null) {
                return "";
            }
            return date("H:i", strtotime($model->jam_masuk));
        }, "jam_pulang" => function ($model) {
            if ($model->jam_pulang == null) {
                return "";
            }
            return date("H:i", strtotime($model->jam_pulang));
        }, "status_kerja", "status", "action" => function ($model) {
            if ($model->jam_pulang == null) {
                return \yii\helpers\Html::button("Pulang", array("class" => "btn-pulang", "data_id" => $model->id));
            }
            return "";
        });
    }
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
            $this->created_by = \Yii::$app->user->id;
        } else {
            $this->updated_at = date("Y-m-d H:i:s");
            $this->updated_by = \Yii::$app->user->id;
        }
        $this->is_need_update = 1;
        if (\Yii::$app->user->isGuest) {
            BreachLog::addLog();
            return false;
        }
        return true;
    }
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $hariAktif = HariAktif::find()->where(array("jaringan_id" => Jaringan::getCurrentID(), "tanggal" => date("Y-m-d", strtotime($this->jam_masuk))))->one();
            if ($hariAktif == null) {
                $hariAktif = new HariAktif();
                $hariAktif->jaringan_id = Jaringan::getCurrentID();
                $hariAktif->tanggal = date("Y-m-d", strtotime($this->jam_masuk));
                $hariAktif->save();
            }
        }
    }
}

?>