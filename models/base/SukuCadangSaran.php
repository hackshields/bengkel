<?php

namespace app\models\base;

class SukuCadangSaran extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "suku_cadang_saran";
    }
    public function rules()
    {
        return array(array(array("kode", "nama"), "required"), array(array("suku_cadang_group_id", "suku_cadang_kategori_id", "merek_id", "rank", "het", "status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 50), array(array("kode_plasa", "kode_promosi"), "string", "max" => 6), array(array("nama", "nama_sinonim"), "string", "max" => 100), array(array("fs", "import"), "string", "max" => 11), array(array("lifetime", "fungsi"), "string", "max" => 1), array(array("dimensi_panjang", "dimensi_lebar", "dimensi_tinggi", "dimensi_berat"), "string", "max" => 10), array(array("foto"), "string", "max" => 255));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "kode" => "Kode", "kode_plasa" => "Kode Plasa", "nama" => "Nama", "nama_sinonim" => "Nama Sinonim", "suku_cadang_group_id" => "Group", "suku_cadang_kategori_id" => "Kategori", "merek_id" => "Merek", "fs" => "FS", "import" => "Import", "rank" => "Rank", "lifetime" => "Lifetime", "fungsi" => "Fungsi", "het" => "HET", "kode_promosi" => "Kode Promosi", "dimensi_panjang" => "Dimensi Panjang", "dimensi_lebar" => "Dimensi Lebar", "dimensi_tinggi" => "Dimensi Tinggi", "dimensi_berat" => "Dimensi Berat", "foto" => "Foto", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getSukuCadangGroup()
    {
        return $this->hasOne(\app\models\SukuCadangGroup::className(), array("id" => "suku_cadang_group_id"));
    }
    public function getSukuCadangKategori()
    {
        return $this->hasOne(\app\models\SukuCadangKategori::className(), array("id" => "suku_cadang_kategori_id"));
    }
    public function getMerek()
    {
        return $this->hasOne(\app\models\Merek::className(), array("id" => "merek_id"));
    }
}

?>