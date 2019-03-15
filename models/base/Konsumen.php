<?php

namespace app\models\base;

class Konsumen extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "konsumen";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "kode", "jenis_identitas", "no_identitas", "nama_identitas"), "required"), array(array("jaringan_id", "wilayah_propinsi_id", "wilayah_kabupaten_id", "wilayah_kecamatan_id", "wilayah_desa_id", "konsumen_group_id", "motor_id", "tahun_rakit", "kilometer_terakhir", "sms", "created_by", "updated_by"), "integer"), array(array("tanggal_lahir", "tanggal_beli", "service_terakhir", "created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 30), array(array("jenis_identitas"), "string", "max" => 5), array(array("no_identitas"), "string", "max" => 25), array(array("nama_identitas", "nama_pengguna", "facebook", "instagram", "twitter", "nama_dealer_beli", "kota_dealer_beli"), "string", "max" => 100), array(array("alamat"), "string", "max" => 200), array(array("kodepos"), "string", "max" => 6), array(array("no_telepon", "email", "tempat_lahir", "pendidikan", "pekerjaan", "no_mesin", "no_rangka"), "string", "max" => 50), array(array("no_whatsapp", "agama"), "string", "max" => 20), array(array("jenis_kelamin"), "string", "max" => 1), array(array("nopol"), "string", "max" => 12));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "kode" => "Kode", "jenis_identitas" => "Jenis Identitas", "no_identitas" => "No Identitas", "nama_identitas" => "Nama Identitas", "nama_pengguna" => "Nama Pengguna", "alamat" => "Alamat", "wilayah_propinsi_id" => "Wilayah Propinsi ID", "wilayah_kabupaten_id" => "Wilayah Kabupaten ID", "wilayah_kecamatan_id" => "Wilayah Kecamatan ID", "wilayah_desa_id" => "Wilayah Desa ID", "kodepos" => "Kodepos", "no_telepon" => "No Telepon", "email" => "Email", "no_whatsapp" => "No Whatsapp", "facebook" => "Facebook", "instagram" => "Instagram", "twitter" => "Twitter", "tempat_lahir" => "Tempat Lahir", "jenis_kelamin" => "Jenis Kelamin", "agama" => "Agama", "tanggal_lahir" => "Tanggal Lahir", "pendidikan" => "Pendidikan", "pekerjaan" => "Pekerjaan", "konsumen_group_id" => "Konsumen Group ID", "nopol" => "Nopol", "motor_id" => "Motor ID", "no_mesin" => "No Mesin", "no_rangka" => "No Rangka", "tahun_rakit" => "Tahun Rakit", "tanggal_beli" => "Tanggal Beli", "nama_dealer_beli" => "Nama Dealer Beli", "kota_dealer_beli" => "Kota Dealer Beli", "service_terakhir" => "Service Terakhir", "kilometer_terakhir" => "Kilometer Terakhir", "sms" => "Sms", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getWilayahPropinsi()
    {
        return $this->hasOne(\app\models\WilayahPropinsi::className(), array("id" => "wilayah_propinsi_id"));
    }
    public function getWilayahKabupaten()
    {
        return $this->hasOne(\app\models\WilayahKabupaten::className(), array("id" => "wilayah_kabupaten_id"));
    }
    public function getWilayahKecamatan()
    {
        return $this->hasOne(\app\models\WilayahKecamatan::className(), array("id" => "wilayah_kecamatan_id"));
    }
    public function getWilayahDesa()
    {
        return $this->hasOne(\app\models\WilayahDesa::className(), array("id" => "wilayah_desa_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getKonsumenGroup()
    {
        return $this->hasOne(\app\models\KonsumenGroup::className(), array("id" => "konsumen_group_id"));
    }
    public function getMotor()
    {
        return $this->hasOne(\app\models\Motor::className(), array("id" => "motor_id"));
    }
    public function getPengeluaranParts()
    {
        return $this->hasMany(\app\models\PengeluaranPart::className(), array("konsumen_id" => "id"));
    }
    public function getPengeluaranParts0()
    {
        return $this->hasMany(\app\models\PengeluaranPart::className(), array("konsumen_penerima_id" => "id"));
    }
    public function getPerintahKerjas()
    {
        return $this->hasMany(\app\models\PerintahKerja::className(), array("konsumen_id" => "id"));
    }
}

?>