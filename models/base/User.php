<?php

namespace app\models\base;

class User extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "user";
    }
    public function rules()
    {
        return array(array(array("username", "password", "name", "role_id"), "required"), array(array("role_id", "jaringan_id", "wilayah_propinsi_id", "wilayah_kabupaten_id", "wilayah_kecamatan_id", "wilayah_desa_id", "is_on_duty", "pit_id", "status"), "integer"), array(array("tanggal_lahir", "tanggal_masuk", "tanggal_keluar", "last_login", "last_logout"), "safe"), array(array("username", "password", "name", "token", "email", "tempat_lahir"), "string", "max" => 50), array(array("kode"), "string", "max" => 30), array(array("photo_url"), "string", "max" => 255), array(array("alamat"), "string", "max" => 200), array(array("kodepos"), "string", "max" => 6), array(array("no_telpon", "pendidikan"), "string", "max" => 20), array(array("agama"), "string", "max" => 15), array(array("jenis_kelamin"), "string", "max" => 1), array(array("username"), "unique"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "username" => "Username", "password" => "Password", "kode" => "Kode", "name" => "Name", "role_id" => "Role ID", "photo_url" => "Photo Url", "jaringan_id" => "Jaringan ID", "token" => "Token", "alamat" => "Alamat", "wilayah_propinsi_id" => "Wilayah Propinsi ID", "wilayah_kabupaten_id" => "Wilayah Kabupaten ID", "wilayah_kecamatan_id" => "Wilayah Kecamatan ID", "wilayah_desa_id" => "Wilayah Desa ID", "kodepos" => "Kodepos", "no_telpon" => "No Telpon", "email" => "Email", "tempat_lahir" => "Tempat Lahir", "tanggal_lahir" => "Tanggal Lahir", "agama" => "Agama", "jenis_kelamin" => "Jenis Kelamin", "pendidikan" => "Pendidikan", "tanggal_masuk" => "Tanggal Masuk", "tanggal_keluar" => "Tanggal Keluar", "is_on_duty" => "Is On Duty", "pit_id" => "Pit ID", "last_login" => "Last Login", "last_logout" => "Last Logout", "status" => "Status");
    }
    public function getAbsensis()
    {
        return $this->hasMany(\app\models\Absensi::className(), array("created_by" => "id"));
    }
    public function getAbsensis0()
    {
        return $this->hasMany(\app\models\Absensi::className(), array("updated_by" => "id"));
    }
    public function getAbsensis1()
    {
        return $this->hasMany(\app\models\Absensi::className(), array("karyawan_id" => "id"));
    }
    public function getAbsensiStatuses()
    {
        return $this->hasMany(\app\models\AbsensiStatus::className(), array("created_by" => "id"));
    }
    public function getAbsensiStatuses0()
    {
        return $this->hasMany(\app\models\AbsensiStatus::className(), array("updated_by" => "id"));
    }
    public function getBebanPembayarans()
    {
        return $this->hasMany(\app\models\BebanPembayaran::className(), array("created_by" => "id"));
    }
    public function getBebanPembayarans0()
    {
        return $this->hasMany(\app\models\BebanPembayaran::className(), array("updated_by" => "id"));
    }
    public function getCheckpoints()
    {
        return $this->hasMany(\app\models\Checkpoint::className(), array("created_by" => "id"));
    }
    public function getCheckpoints0()
    {
        return $this->hasMany(\app\models\Checkpoint::className(), array("updated_by" => "id"));
    }
    public function getCheckpointGroups()
    {
        return $this->hasMany(\app\models\CheckpointGroup::className(), array("created_by" => "id"));
    }
    public function getCheckpointGroups0()
    {
        return $this->hasMany(\app\models\CheckpointGroup::className(), array("updated_by" => "id"));
    }
    public function getCheckpointItems()
    {
        return $this->hasMany(\app\models\CheckpointItem::className(), array("created_by" => "id"));
    }
    public function getCheckpointItems0()
    {
        return $this->hasMany(\app\models\CheckpointItem::className(), array("updated_by" => "id"));
    }
    public function getGudangs()
    {
        return $this->hasMany(\app\models\Gudang::className(), array("created_by" => "id"));
    }
    public function getGudangs0()
    {
        return $this->hasMany(\app\models\Gudang::className(), array("updated_by" => "id"));
    }
    public function getJaringans()
    {
        return $this->hasMany(\app\models\Jaringan::className(), array("created_by" => "id"));
    }
    public function getJaringans0()
    {
        return $this->hasMany(\app\models\Jaringan::className(), array("updated_by" => "id"));
    }
    public function getJaringanKategoris()
    {
        return $this->hasMany(\app\models\JaringanKategori::className(), array("created_by" => "id"));
    }
    public function getJaringanKategoris0()
    {
        return $this->hasMany(\app\models\JaringanKategori::className(), array("updated_by" => "id"));
    }
    public function getJasas()
    {
        return $this->hasMany(\app\models\Jasa::className(), array("created_by" => "id"));
    }
    public function getJasas0()
    {
        return $this->hasMany(\app\models\Jasa::className(), array("updated_by" => "id"));
    }
    public function getJasaGroups()
    {
        return $this->hasMany(\app\models\JasaGroup::className(), array("created_by" => "id"));
    }
    public function getJasaGroups0()
    {
        return $this->hasMany(\app\models\JasaGroup::className(), array("updated_by" => "id"));
    }
    public function getKaryawans()
    {
        return $this->hasMany(\app\models\Karyawan::className(), array("updated_by" => "id"));
    }
    public function getKaryawans0()
    {
        return $this->hasMany(\app\models\Karyawan::className(), array("created_by" => "id"));
    }
    public function getKonsumens()
    {
        return $this->hasMany(\app\models\Konsumen::className(), array("created_by" => "id"));
    }
    public function getKonsumens0()
    {
        return $this->hasMany(\app\models\Konsumen::className(), array("updated_by" => "id"));
    }
    public function getKonsumenGroups()
    {
        return $this->hasMany(\app\models\KonsumenGroup::className(), array("updated_by" => "id"));
    }
    public function getKonsumenGroups0()
    {
        return $this->hasMany(\app\models\KonsumenGroup::className(), array("created_by" => "id"));
    }
    public function getKpbs()
    {
        return $this->hasMany(\app\models\Kpb::className(), array("created_by" => "id"));
    }
    public function getKpbs0()
    {
        return $this->hasMany(\app\models\Kpb::className(), array("updated_by" => "id"));
    }
    public function getMainDealers()
    {
        return $this->hasMany(\app\models\MainDealer::className(), array("created_by" => "id"));
    }
    public function getMainDealers0()
    {
        return $this->hasMany(\app\models\MainDealer::className(), array("updated_by" => "id"));
    }
    public function getMereks()
    {
        return $this->hasMany(\app\models\Merek::className(), array("created_by" => "id"));
    }
    public function getMereks0()
    {
        return $this->hasMany(\app\models\Merek::className(), array("updated_by" => "id"));
    }
    public function getMotors()
    {
        return $this->hasMany(\app\models\Motor::className(), array("created_by" => "id"));
    }
    public function getMotors0()
    {
        return $this->hasMany(\app\models\Motor::className(), array("updated_by" => "id"));
    }
    public function getMotorGroups()
    {
        return $this->hasMany(\app\models\MotorGroup::className(), array("created_by" => "id"));
    }
    public function getMotorGroups0()
    {
        return $this->hasMany(\app\models\MotorGroup::className(), array("updated_by" => "id"));
    }
    public function getMotorJenis()
    {
        return $this->hasMany(\app\models\MotorJenis::className(), array("created_by" => "id"));
    }
    public function getMotorJenis0()
    {
        return $this->hasMany(\app\models\MotorJenis::className(), array("updated_by" => "id"));
    }
    public function getNotaJasas()
    {
        return $this->hasMany(\app\models\NotaJasa::className(), array("created_by" => "id"));
    }
    public function getNotaJasas0()
    {
        return $this->hasMany(\app\models\NotaJasa::className(), array("updated_by" => "id"));
    }
    public function getNotaJasas1()
    {
        return $this->hasMany(\app\models\NotaJasa::className(), array("karyawan_id" => "id"));
    }
    public function getNotaJasaDetails()
    {
        return $this->hasMany(\app\models\NotaJasaDetail::className(), array("created_by" => "id"));
    }
    public function getNotaJasaDetails0()
    {
        return $this->hasMany(\app\models\NotaJasaDetail::className(), array("updated_by" => "id"));
    }
    public function getPembayarans()
    {
        return $this->hasMany(\app\models\Pembayaran::className(), array("created_by" => "id"));
    }
    public function getPembayarans0()
    {
        return $this->hasMany(\app\models\Pembayaran::className(), array("updated_by" => "id"));
    }
    public function getPenerimaanParts()
    {
        return $this->hasMany(\app\models\PenerimaanPart::className(), array("approved_by" => "id"));
    }
    public function getPenerimaanParts0()
    {
        return $this->hasMany(\app\models\PenerimaanPart::className(), array("created_by" => "id"));
    }
    public function getPenerimaanParts1()
    {
        return $this->hasMany(\app\models\PenerimaanPart::className(), array("updated_by" => "id"));
    }
    public function getPenerimaanPartDetails()
    {
        return $this->hasMany(\app\models\PenerimaanPartDetail::className(), array("created_by" => "id"));
    }
    public function getPenerimaanPartDetails0()
    {
        return $this->hasMany(\app\models\PenerimaanPartDetail::className(), array("updated_by" => "id"));
    }
    public function getPenerimaanPartTipes()
    {
        return $this->hasMany(\app\models\PenerimaanPartTipe::className(), array("created_by" => "id"));
    }
    public function getPenerimaanPartTipes0()
    {
        return $this->hasMany(\app\models\PenerimaanPartTipe::className(), array("updated_by" => "id"));
    }
    public function getPengeluaranParts()
    {
        return $this->hasMany(\app\models\PengeluaranPart::className(), array("sales_id" => "id"));
    }
    public function getPengeluaranParts0()
    {
        return $this->hasMany(\app\models\PengeluaranPart::className(), array("approved_by" => "id"));
    }
    public function getPengeluaranParts1()
    {
        return $this->hasMany(\app\models\PengeluaranPart::className(), array("created_by" => "id"));
    }
    public function getPengeluaranParts2()
    {
        return $this->hasMany(\app\models\PengeluaranPart::className(), array("updated_by" => "id"));
    }
    public function getPengeluaranPartDetails()
    {
        return $this->hasMany(\app\models\PengeluaranPartDetail::className(), array("mekanik_penerima_id" => "id"));
    }
    public function getPengeluaranPartDetails0()
    {
        return $this->hasMany(\app\models\PengeluaranPartDetail::className(), array("created_by" => "id"));
    }
    public function getPengeluaranPartDetails1()
    {
        return $this->hasMany(\app\models\PengeluaranPartDetail::className(), array("updated_by" => "id"));
    }
    public function getPengeluaranPartTipes()
    {
        return $this->hasMany(\app\models\PengeluaranPartTipe::className(), array("created_by" => "id"));
    }
    public function getPengeluaranPartTipes0()
    {
        return $this->hasMany(\app\models\PengeluaranPartTipe::className(), array("updated_by" => "id"));
    }
    public function getPerintahKerjas()
    {
        return $this->hasMany(\app\models\PerintahKerja::className(), array("karyawan_id" => "id"));
    }
    public function getPerintahKerjas0()
    {
        return $this->hasMany(\app\models\PerintahKerja::className(), array("created_by" => "id"));
    }
    public function getPerintahKerjas1()
    {
        return $this->hasMany(\app\models\PerintahKerja::className(), array("updated_by" => "id"));
    }
    public function getPerintahKerjaCheckpoints()
    {
        return $this->hasMany(\app\models\PerintahKerjaCheckpoint::className(), array("created_by" => "id"));
    }
    public function getPerintahKerjaCheckpoints0()
    {
        return $this->hasMany(\app\models\PerintahKerjaCheckpoint::className(), array("updated_by" => "id"));
    }
    public function getPerintahKerjaJasas()
    {
        return $this->hasMany(\app\models\PerintahKerjaJasa::className(), array("created_by" => "id"));
    }
    public function getPerintahKerjaJasas0()
    {
        return $this->hasMany(\app\models\PerintahKerjaJasa::className(), array("updated_by" => "id"));
    }
    public function getPerintahKerjaStatuses()
    {
        return $this->hasMany(\app\models\PerintahKerjaStatus::className(), array("created_by" => "id"));
    }
    public function getPerintahKerjaStatuses0()
    {
        return $this->hasMany(\app\models\PerintahKerjaStatus::className(), array("updated_by" => "id"));
    }
    public function getPerintahKerjaSukuCadangs()
    {
        return $this->hasMany(\app\models\PerintahKerjaSukuCadang::className(), array("created_by" => "id"));
    }
    public function getPerintahKerjaSukuCadangs0()
    {
        return $this->hasMany(\app\models\PerintahKerjaSukuCadang::className(), array("updated_by" => "id"));
    }
    public function getPerintahKerjaTipes()
    {
        return $this->hasMany(\app\models\PerintahKerjaTipe::className(), array("created_by" => "id"));
    }
    public function getPerintahKerjaTipes0()
    {
        return $this->hasMany(\app\models\PerintahKerjaTipe::className(), array("updated_by" => "id"));
    }
    public function getPromos()
    {
        return $this->hasMany(\app\models\Promo::className(), array("created_by" => "id"));
    }
    public function getPromos0()
    {
        return $this->hasMany(\app\models\Promo::className(), array("updated_by" => "id"));
    }
    public function getPurchaseOrders()
    {
        return $this->hasMany(\app\models\PurchaseOrder::className(), array("created_by" => "id"));
    }
    public function getPurchaseOrders0()
    {
        return $this->hasMany(\app\models\PurchaseOrder::className(), array("updated_by" => "id"));
    }
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(\app\models\PurchaseOrderDetail::className(), array("created_by" => "id"));
    }
    public function getPurchaseOrderDetails0()
    {
        return $this->hasMany(\app\models\PurchaseOrderDetail::className(), array("updated_by" => "id"));
    }
    public function getPurchaseOrderStatuses()
    {
        return $this->hasMany(\app\models\PurchaseOrderStatus::className(), array("created_by" => "id"));
    }
    public function getPurchaseOrderStatuses0()
    {
        return $this->hasMany(\app\models\PurchaseOrderStatus::className(), array("updated_by" => "id"));
    }
    public function getPurchaseOrderTipes()
    {
        return $this->hasMany(\app\models\PurchaseOrderTipe::className(), array("created_by" => "id"));
    }
    public function getPurchaseOrderTipes0()
    {
        return $this->hasMany(\app\models\PurchaseOrderTipe::className(), array("updated_by" => "id"));
    }
    public function getRaks()
    {
        return $this->hasMany(\app\models\Rak::className(), array("created_by" => "id"));
    }
    public function getRaks0()
    {
        return $this->hasMany(\app\models\Rak::className(), array("updated_by" => "id"));
    }
    public function getRakJenis()
    {
        return $this->hasMany(\app\models\RakJenis::className(), array("created_by" => "id"));
    }
    public function getRakJenis0()
    {
        return $this->hasMany(\app\models\RakJenis::className(), array("updated_by" => "id"));
    }
    public function getStatusHutangs()
    {
        return $this->hasMany(\app\models\StatusHutang::className(), array("created_by" => "id"));
    }
    public function getStatusHutangs0()
    {
        return $this->hasMany(\app\models\StatusHutang::className(), array("updated_by" => "id"));
    }
    public function getStatusNjbs()
    {
        return $this->hasMany(\app\models\StatusNjb::className(), array("created_by" => "id"));
    }
    public function getStatusNjbs0()
    {
        return $this->hasMany(\app\models\StatusNjb::className(), array("updated_by" => "id"));
    }
    public function getStatusNscs()
    {
        return $this->hasMany(\app\models\StatusNsc::className(), array("created_by" => "id"));
    }
    public function getStatusNscs0()
    {
        return $this->hasMany(\app\models\StatusNsc::className(), array("updated_by" => "id"));
    }
    public function getStatusOpnames()
    {
        return $this->hasMany(\app\models\StatusOpname::className(), array("created_by" => "id"));
    }
    public function getStatusOpnames0()
    {
        return $this->hasMany(\app\models\StatusOpname::className(), array("updated_by" => "id"));
    }
    public function getStatusPembayarans()
    {
        return $this->hasMany(\app\models\StatusPembayaran::className(), array("created_by" => "id"));
    }
    public function getStatusPembayarans0()
    {
        return $this->hasMany(\app\models\StatusPembayaran::className(), array("updated_by" => "id"));
    }
    public function getStatusSpgs()
    {
        return $this->hasMany(\app\models\StatusSpg::className(), array("created_by" => "id"));
    }
    public function getStatusSpgs0()
    {
        return $this->hasMany(\app\models\StatusSpg::className(), array("updated_by" => "id"));
    }
    public function getStockOpnames()
    {
        return $this->hasMany(\app\models\StockOpname::className(), array("created_by" => "id"));
    }
    public function getStockOpnames0()
    {
        return $this->hasMany(\app\models\StockOpname::className(), array("updated_by" => "id"));
    }
    public function getStockOpnameDetails()
    {
        return $this->hasMany(\app\models\StockOpnameDetail::className(), array("created_by" => "id"));
    }
    public function getStockOpnameDetails0()
    {
        return $this->hasMany(\app\models\StockOpnameDetail::className(), array("updated_by" => "id"));
    }
    public function getStockOpnameRecounts()
    {
        return $this->hasMany(\app\models\StockOpnameRecount::className(), array("created_by" => "id"));
    }
    public function getStockOpnameRecounts0()
    {
        return $this->hasMany(\app\models\StockOpnameRecount::className(), array("updated_by" => "id"));
    }
    public function getSukuCadangs()
    {
        return $this->hasMany(\app\models\SukuCadang::className(), array("created_by" => "id"));
    }
    public function getSukuCadangs0()
    {
        return $this->hasMany(\app\models\SukuCadang::className(), array("updated_by" => "id"));
    }
    public function getSukuCadangGroups()
    {
        return $this->hasMany(\app\models\SukuCadangGroup::className(), array("created_by" => "id"));
    }
    public function getSukuCadangGroups0()
    {
        return $this->hasMany(\app\models\SukuCadangGroup::className(), array("updated_by" => "id"));
    }
    public function getSukuCadangJaringans()
    {
        return $this->hasMany(\app\models\SukuCadangJaringan::className(), array("created_by" => "id"));
    }
    public function getSukuCadangJaringans0()
    {
        return $this->hasMany(\app\models\SukuCadangJaringan::className(), array("updated_by" => "id"));
    }
    public function getSukuCadangKategoris()
    {
        return $this->hasMany(\app\models\SukuCadangKategori::className(), array("created_by" => "id"));
    }
    public function getSukuCadangKategoris0()
    {
        return $this->hasMany(\app\models\SukuCadangKategori::className(), array("updated_by" => "id"));
    }
    public function getSukuCadangKosongs()
    {
        return $this->hasMany(\app\models\SukuCadangKosong::className(), array("created_by" => "id"));
    }
    public function getSukuCadangKosongs0()
    {
        return $this->hasMany(\app\models\SukuCadangKosong::className(), array("updated_by" => "id"));
    }
    public function getSuppliers()
    {
        return $this->hasMany(\app\models\Supplier::className(), array("created_by" => "id"));
    }
    public function getSuppliers0()
    {
        return $this->hasMany(\app\models\Supplier::className(), array("updated_by" => "id"));
    }
    public function getRole()
    {
        return $this->hasOne(\app\models\Role::className(), array("id" => "role_id"));
    }
    public function getWilayahKecamatan()
    {
        return $this->hasOne(\app\models\WilayahKecamatan::className(), array("id" => "wilayah_kecamatan_id"));
    }
    public function getWilayahDesa()
    {
        return $this->hasOne(\app\models\WilayahDesa::className(), array("id" => "wilayah_desa_id"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getPit()
    {
        return $this->hasOne(\app\models\Pit::className(), array("id" => "pit_id"));
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