<?php

namespace app\models\base;

class Karyawan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "karyawan";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "kode", "nama", "alamat"), "required"), array(array("jaringan_id", "wilayah_propinsi_id", "wilayah_kabupaten_id", "wilayah_kecamatan_id", "wilayah_desa_id", "kodepos", "on_duty", "status", "updated_by", "created_by"), "integer"), array(array("tanggal_lahir", "tanggal_keluar", "tanggal_masuk", "updated_at", "created_at"), "safe"), array(array("kode", "pit"), "string", "max" => 5), array(array("nama", "email", "tempat_lahir", "jabatan"), "string", "max" => 50), array(array("alamat"), "string", "max" => 100), array(array("no_telpon", "agama", "pendidikan"), "string", "max" => 20), array(array("jenis_kelamin"), "string", "max" => 1));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "kode" => "Kode", "nama" => "Nama", "alamat" => "Alamat", "wilayah_propinsi_id" => "Wilayah Propinsi ID", "wilayah_kabupaten_id" => "Wilayah Kabupaten ID", "wilayah_kecamatan_id" => "Wilayah Kecamatan ID", "wilayah_desa_id" => "Wilayah Desa ID", "kodepos" => "Kodepos", "no_telpon" => "No Telpon", "email" => "Email", "tempat_lahir" => "Tempat Lahir", "tanggal_lahir" => "Tanggal Lahir", "agama" => "Agama", "jenis_kelamin" => "Jenis Kelamin", "jabatan" => "Jabatan", "pendidikan" => "Pendidikan", "tanggal_keluar" => "Tanggal Keluar", "on_duty" => "On Duty", "pit" => "Pit", "tanggal_masuk" => "Tanggal Masuk", "status" => "Status", "updated_at" => "Updated At", "created_at" => "Created At", "updated_by" => "Updated By", "created_by" => "Created By");
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
    public function getNotaJasas()
    {
        return $this->hasMany(\app\models\NotaJasa::className(), array("approved_by" => "id"));
    }
    public function getStockOpnames()
    {
        return $this->hasMany(\app\models\StockOpname::className(), array("petugas_id" => "id"));
    }
}

?>