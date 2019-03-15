<?php

namespace app\models\base;

class PerintahKerja extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "perintah_kerja";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "nomor"), "required"), array(array("jaringan_id", "perintah_kerja_tipe_id", "konsumen_id", "karyawan_id", "km", "bbm", "konfirmasi", "dari_sms", "perintah_kerja_alasan_id", "durasi_service", "jumlah_tunggu_menit", "nomor_cetak", "perintah_kerja_status_id", "status_njb_id", "status_nsc_id", "tunai_nominal", "debit_nominal", "created_by", "updated_by"), "integer"), array(array("tanggal_ass", "waktu_daftar", "waktu_kerja", "waktu_selesai", "waktu_pause", "waktu_resume", "created_at", "updated_at"), "safe"), array(array("nomor"), "string", "max" => 20), array(array("no_antrian"), "string", "max" => 6), array(array("kondisi_awal", "keluhan", "analisa", "catatan"), "string", "max" => 100), array(array("debit_terminal", "debit_bank", "debit_no_kartu", "debit_pemilik", "debit_approval_code"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "perintah_kerja_tipe_id" => "Perintah Kerja Tipe ID", "nomor" => "Nomor", "tanggal_ass" => "Tanggal Ass", "no_antrian" => "No Antrian", "konsumen_id" => "Konsumen ID", "karyawan_id" => "Karyawan ID", "kondisi_awal" => "Kondisi Awal", "keluhan" => "Keluhan", "analisa" => "Analisa", "km" => "Km", "bbm" => "Bbm", "konfirmasi" => "Konfirmasi", "dari_sms" => "Dari Sms", "perintah_kerja_alasan_id" => "Perintah Kerja Alasan ID", "catatan" => "Catatan", "waktu_daftar" => "Waktu Daftar", "waktu_kerja" => "Waktu Kerja", "waktu_selesai" => "Waktu Selesai", "waktu_pause" => "Waktu Pause", "waktu_resume" => "Waktu Resume", "durasi_service" => "Durasi Service", "jumlah_tunggu_menit" => "Jumlah Tunggu Menit", "nomor_cetak" => "Nomor Cetak", "perintah_kerja_status_id" => "Perintah Kerja Status ID", "status_njb_id" => "Status Njb ID", "status_nsc_id" => "Status Nsc ID", "tunai_nominal" => "Tunai Nominal", "debit_nominal" => "Debit Nominal", "debit_terminal" => "Debit Terminal", "debit_bank" => "Debit Bank", "debit_no_kartu" => "Debit No Kartu", "debit_pemilik" => "Debit Pemilik", "debit_approval_code" => "Debit Approval Code", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getNotaJasas()
    {
        return $this->hasMany(\app\models\NotaJasa::className(), array("perintah_kerja_id" => "id"));
    }
    public function getPengeluaranParts()
    {
        return $this->hasMany(\app\models\PengeluaranPart::className(), array("no_referensi" => "id"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getKaryawan()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "karyawan_id"));
    }
    public function getPerintahKerjaAlasan()
    {
        return $this->hasOne(\app\models\PerintahKerjaAlasan::className(), array("id" => "perintah_kerja_alasan_id"));
    }
    public function getPerintahKerjaTipe()
    {
        return $this->hasOne(\app\models\PerintahKerjaTipe::className(), array("id" => "perintah_kerja_tipe_id"));
    }
    public function getKonsumen()
    {
        return $this->hasOne(\app\models\Konsumen::className(), array("id" => "konsumen_id"));
    }
    public function getPerintahKerjaStatus()
    {
        return $this->hasOne(\app\models\PerintahKerjaStatus::className(), array("id" => "perintah_kerja_status_id"));
    }
    public function getStatusNjb()
    {
        return $this->hasOne(\app\models\StatusNjb::className(), array("id" => "status_njb_id"));
    }
    public function getStatusNsc()
    {
        return $this->hasOne(\app\models\StatusNsc::className(), array("id" => "status_nsc_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getPerintahKerjaCheckpoints()
    {
        return $this->hasMany(\app\models\PerintahKerjaCheckpoint::className(), array("perintah_kerja_id" => "id"));
    }
    public function getPerintahKerjaJasas()
    {
        return $this->hasMany(\app\models\PerintahKerjaJasa::className(), array("perintah_kerja_id" => "id"));
    }
    public function getPerintahKerjaSukuCadangs()
    {
        return $this->hasMany(\app\models\PerintahKerjaSukuCadang::className(), array("perintah_kerja_id" => "id"));
    }
}

?>