<?php

namespace app\models\base;

class KonsumenGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "konsumen_group";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "kode", "nama", "alamat"), "required"), array(array("jaringan_id", "wilayah_propinsi_id", "wilayah_kabupaten_id", "wilayah_kecamatan_id", "wilayah_desa_id", "plafon", "status_plafon", "kredit", "status", "updated_by", "created_by"), "integer"), array(array("tanggal_kontrak_awal", "tanggal_kontrak_akhir", "updated_at", "created_at"), "safe"), array(array("diskon_jasa", "diskon_suku_cadang"), "number"), array(array("kode", "kodepos"), "string", "max" => 6), array(array("nama"), "string", "max" => 100), array(array("alamat"), "string", "max" => 200), array(array("no_telpon", "no_telpon_pic"), "string", "max" => 20), array(array("email", "pic"), "string", "max" => 50), array(array("no_kontrak"), "string", "max" => 30));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "kode" => "Kode", "nama" => "Nama", "alamat" => "Alamat", "wilayah_propinsi_id" => "Wilayah Propinsi ID", "wilayah_kabupaten_id" => "Wilayah Kabupaten ID", "wilayah_kecamatan_id" => "Wilayah Kecamatan ID", "wilayah_desa_id" => "Wilayah Desa ID", "kodepos" => "Kodepos", "no_telpon" => "No Telpon", "email" => "Email", "pic" => "Pic", "no_telpon_pic" => "No Telpon Pic", "no_kontrak" => "No Kontrak", "tanggal_kontrak_awal" => "Tanggal Kontrak Awal", "diskon_jasa" => "Diskon Jasa", "tanggal_kontrak_akhir" => "Tanggal Kontrak Akhir", "plafon" => "Plafon", "status_plafon" => "Status Plafon", "kredit" => "Kredit", "diskon_suku_cadang" => "Diskon Suku Cadang", "status" => "Status", "updated_at" => "Updated At", "created_at" => "Created At", "updated_by" => "Updated By", "created_by" => "Created By");
    }
    public function getKonsumens()
    {
        return $this->hasMany(\app\models\Konsumen::className(), array("konsumen_group_id" => "id"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getWilayahKecamatan()
    {
        return $this->hasOne(\app\models\WilayahKecamatan::className(), array("id" => "wilayah_kecamatan_id"));
    }
    public function getWilayahDesa()
    {
        return $this->hasOne(\app\models\WilayahDesa::className(), array("id" => "wilayah_desa_id"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getWilayahPropinsi()
    {
        return $this->hasOne(\app\models\WilayahPropinsi::className(), array("id" => "wilayah_propinsi_id"));
    }
    public function getWilayahKabupaten()
    {
        return $this->hasOne(\app\models\WilayahKabupaten::className(), array("id" => "wilayah_kabupaten_id"));
    }
}

?>