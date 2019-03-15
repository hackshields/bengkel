<?php

namespace app\models;

class Konsumen extends base\Konsumen
{
    public static function getCurrentActive()
    {
        return Konsumen::find()->where(array("jaringan_id" => \Yii::$app->user->identity->jaringan_id))->all();
    }
    public function getNopolNama()
    {
        return $this->nopol . " - " . $this->nama_identitas;
    }
    public function fields()
    {
        return array("id", "jaringan_id", "kode", "jenis_identitas", "no_identitas", "nama_identitas", "nama_pengguna", "alamat", "wilayah_propinsi_id", "wilayah_kabupaten_id", "wilayah_kabupaten_nama" => function ($model) {
            return $model->wilayahKabupaten->nama;
        }, "wilayah_kecamatan_id", "wilayah_desa_id", "kodepos", "no_telepon", "email", "no_whatsapp", "facebook", "instagram", "twitter", "tempat_lahir", "jenis_kelamin", "agama", "tanggal_lahir", "pendidikan", "pekerjaan", "konsumen_group_id", "nopol", "motor_id", "motor_nama" => function ($model) {
            return $model->motor->nama;
        }, "no_mesin", "no_rangka", "tahun_rakit", "tanggal_beli", "nama_dealer_beli", "kota_dealer_beli", "service_terakhir", "kilometer_terakhir", "sms", "created_at", "updated_at", "created_by", "updated_by", "action" => function ($model) {
            return \yii\helpers\Html::button("Gunakan", array("class" => "btn-konsumen-gunakan", "data_id" => $model->id));
        });
    }
    public function getNama()
    {
        if ($this->nama_pengguna == "") {
            return $this->nama_identitas;
        }
        return $this->nama_pengguna;
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
}

?>