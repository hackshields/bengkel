<?php

namespace app\models\base;

class Jaringan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "jaringan";
    }
    public function rules()
    {
        return array(array(array("kode_registrasi", "kode", "main_dealer_id", "jaringan_kategori_id", "merek_id", "nama"), "required"), array(array("main_dealer_id", "jaringan_kategori_id", "merek_id", "wilayah_propinsi_id", "wilayah_kabupaten_id", "wilayah_kecamatan_id", "wilayah_desa_id", "status", "status_merchant", "persentase_harga_jual", "created_by", "updated_by", "online_id", "is_need_update"), "integer"), array(array("tanggal_registrasi", "tanggal_kedaluarsa", "created_at", "updated_at"), "safe"), array(array("kode_registrasi", "kode"), "string", "max" => 10), array(array("nama", "email", "website", "facebook"), "string", "max" => 100), array(array("alamat"), "string", "max" => 200), array(array("kodepos"), "string", "max" => 6), array(array("no_telepon"), "string", "max" => 20), array(array("no_whatsapp"), "string", "max" => 30), array(array("serial_no_registrasi"), "string", "max" => 15));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "kode_registrasi" => "Kode Registrasi", "kode" => "Kode", "main_dealer_id" => "Main Dealer ID", "jaringan_kategori_id" => "Jaringan Kategori ID", "merek_id" => "Merek ID", "nama" => "Nama", "alamat" => "Alamat", "wilayah_propinsi_id" => "Wilayah Propinsi ID", "wilayah_kabupaten_id" => "Wilayah Kabupaten ID", "wilayah_kecamatan_id" => "Wilayah Kecamatan ID", "wilayah_desa_id" => "Wilayah Desa ID", "kodepos" => "Kodepos", "no_telepon" => "No Telepon", "email" => "Email", "no_whatsapp" => "No Whatsapp", "website" => "Website", "status" => "Status", "status_merchant" => "Status Merchant", "facebook" => "Facebook", "tanggal_registrasi" => "Tanggal Registrasi", "tanggal_kedaluarsa" => "Tanggal Kedaluarsa", "serial_no_registrasi" => "Serial No Registrasi", "persentase_harga_jual" => "Persentase Harga Jual", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By", "online_id" => "Online ID", "is_need_update" => "Is Need Update");
    }
    public function getAbsensis()
    {
        return $this->hasMany(\app\models\Absensi::className(), array("jaringan_id" => "id"));
    }
    public function getGudangs()
    {
        return $this->hasMany(\app\models\Gudang::className(), array("jaringan_id" => "id"));
    }
    public function getHariAktifs()
    {
        return $this->hasMany(\app\models\HariAktif::className(), array("jaringan_id" => "id"));
    }
    public function getMainDealer()
    {
        return $this->hasOne(\app\models\MainDealer::className(), array("id" => "main_dealer_id"));
    }
    public function getJaringanKategori()
    {
        return $this->hasOne(\app\models\JaringanKategori::className(), array("id" => "jaringan_kategori_id"));
    }
    public function getMerek()
    {
        return $this->hasOne(\app\models\Merek::className(), array("id" => "merek_id"));
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
    public function getJasas()
    {
        return $this->hasMany(\app\models\Jasa::className(), array("jaringan_id" => "id"));
    }
    public function getKaryawans()
    {
        return $this->hasMany(\app\models\Karyawan::className(), array("jaringan_id" => "id"));
    }
    public function getKonsumens()
    {
        return $this->hasMany(\app\models\Konsumen::className(), array("jaringan_id" => "id"));
    }
    public function getKonsumenGroups()
    {
        return $this->hasMany(\app\models\KonsumenGroup::className(), array("jaringan_id" => "id"));
    }
    public function getNotaJasas()
    {
        return $this->hasMany(\app\models\NotaJasa::className(), array("jaringan_id" => "id"));
    }
    public function getNotaJasaDetails()
    {
        return $this->hasMany(\app\models\NotaJasaDetail::className(), array("jaringan_id" => "id"));
    }
    public function getPembeliCarts()
    {
        return $this->hasMany(\app\models\PembeliCart::className(), array("jaringan_id" => "id"));
    }
    public function getPenerimaanParts()
    {
        return $this->hasMany(\app\models\PenerimaanPart::className(), array("jaringan_id" => "id"));
    }
    public function getPenerimaanPartDetails()
    {
        return $this->hasMany(\app\models\PenerimaanPartDetail::className(), array("jaringan_id" => "id"));
    }
    public function getPengeluaranParts()
    {
        return $this->hasMany(\app\models\PengeluaranPart::className(), array("jaringan_id" => "id"));
    }
    public function getPengeluaranPartDetails()
    {
        return $this->hasMany(\app\models\PengeluaranPartDetail::className(), array("jaringan_id" => "id"));
    }
    public function getPerintahKerjas()
    {
        return $this->hasMany(\app\models\PerintahKerja::className(), array("jaringan_id" => "id"));
    }
    public function getPerintahKerjaJasas()
    {
        return $this->hasMany(\app\models\PerintahKerjaJasa::className(), array("jaringan_id" => "id"));
    }
    public function getPerintahKerjaSukuCadangs()
    {
        return $this->hasMany(\app\models\PerintahKerjaSukuCadang::className(), array("jaringan_id" => "id"));
    }
    public function getPits()
    {
        return $this->hasMany(\app\models\Pit::className(), array("jaringan_id" => "id"));
    }
    public function getPromos()
    {
        return $this->hasMany(\app\models\Promo::className(), array("jaringan_id" => "id"));
    }
    public function getPurchaseOrders()
    {
        return $this->hasMany(\app\models\PurchaseOrder::className(), array("jaringan_id" => "id"));
    }
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(\app\models\PurchaseOrderDetail::className(), array("jaringan_id" => "id"));
    }
    public function getRaks()
    {
        return $this->hasMany(\app\models\Rak::className(), array("jaringan_id" => "id"));
    }
    public function getStockOpnames()
    {
        return $this->hasMany(\app\models\StockOpname::className(), array("jaringan_id" => "id"));
    }
    public function getStockOpnameDetails()
    {
        return $this->hasMany(\app\models\StockOpnameDetail::className(), array("jaringan_id" => "id"));
    }
    public function getStockOpnameRecounts()
    {
        return $this->hasMany(\app\models\StockOpnameRecount::className(), array("jaringan_id" => "id"));
    }
    public function getSukuCadangJaringans()
    {
        return $this->hasMany(\app\models\SukuCadangJaringan::className(), array("jaringan_id" => "id"));
    }
    public function getSukuCadangKosongs()
    {
        return $this->hasMany(\app\models\SukuCadangKosong::className(), array("jaringan_id" => "id"));
    }
    public function getSuppliers()
    {
        return $this->hasMany(\app\models\Supplier::className(), array("jaringan_id" => "id"));
    }
    public function getUsers()
    {
        return $this->hasMany(\app\models\User::className(), array("jaringan_id" => "id"));
    }
}

?>