<?php

namespace app\models\base;

class PengeluaranPart extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "pengeluaran_part";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "no_nsc", "pengeluaran_part_tipe_id", "tanggal_pengeluaran", "status_nsc_id"), "required"), array(array("jaringan_id", "pengeluaran_part_tipe_id", "no_referensi", "sales_id", "konsumen_id", "nomor_cetak", "status_nsc_id", "approved_by", "status_pembayaran_id", "total", "tunai_nominal", "debit_nominal", "created_by", "konsumen_penerima_id", "status", "updated_by"), "integer"), array(array("tanggal_pengeluaran", "tanggal_jatuh_tempo", "tanggal_retur", "tanggal_bayar_reguler", "created_at", "updated_at"), "safe"), array(array("keterangan_retur"), "string"), array(array("no_nsc", "bukti_bayar_reguler", "bank_bayar_reguler"), "string", "max" => 30), array(array("konsumen_nama", "konsumen_kota", "debit_terminal", "debit_bank", "debit_no_kartu", "debit_pemilik"), "string", "max" => 50), array(array("konsumen_alamat"), "string", "max" => 200), array(array("catatan"), "string", "max" => 100), array(array("nomor_retur", "debit_approval_code"), "string", "max" => 20));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "no_nsc" => "No Nsc", "pengeluaran_part_tipe_id" => "Pengeluaran Part Tipe ID", "no_referensi" => "No Referensi", "sales_id" => "Sales ID", "tanggal_pengeluaran" => "Tanggal Pengeluaran", "tanggal_jatuh_tempo" => "Tanggal Jatuh Tempo", "konsumen_id" => "Konsumen ID", "konsumen_nama" => "Konsumen Nama", "konsumen_alamat" => "Konsumen Alamat", "konsumen_kota" => "Konsumen Kota", "nomor_cetak" => "Nomor Cetak", "catatan" => "Catatan", "status_nsc_id" => "Status Nsc ID", "keterangan_retur" => "Keterangan Retur", "tanggal_retur" => "Tanggal Retur", "approved_by" => "Approved By", "nomor_retur" => "Nomor Retur", "status_pembayaran_id" => "Status Pembayaran ID", "total" => "Total", "tunai_nominal" => "Tunai Nominal", "debit_nominal" => "Debit Nominal", "debit_terminal" => "Debit Terminal", "debit_bank" => "Debit Bank", "debit_no_kartu" => "Debit No Kartu", "debit_pemilik" => "Debit Pemilik", "debit_approval_code" => "Debit Approval Code", "bukti_bayar_reguler" => "Bukti Bayar Reguler", "tanggal_bayar_reguler" => "Tanggal Bayar Reguler", "created_at" => "Created At", "created_by" => "Created By", "konsumen_penerima_id" => "Konsumen Penerima ID", "status" => "Status", "updated_by" => "Updated By", "bank_bayar_reguler" => "Bank Bayar Reguler", "updated_at" => "Updated At");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getStatusPembayaran()
    {
        return $this->hasOne(\app\models\StatusPembayaran::className(), array("id" => "status_pembayaran_id"));
    }
    public function getNoReferensi()
    {
        return $this->hasOne(\app\models\PerintahKerja::className(), array("id" => "no_referensi"));
    }
    public function getSales()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "sales_id"));
    }
    public function getKonsumen()
    {
        return $this->hasOne(\app\models\Konsumen::className(), array("id" => "konsumen_id"));
    }
    public function getApprovedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "approved_by"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getKonsumenPenerima()
    {
        return $this->hasOne(\app\models\Konsumen::className(), array("id" => "konsumen_penerima_id"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getPengeluaranPartTipe()
    {
        return $this->hasOne(\app\models\PengeluaranPartTipe::className(), array("id" => "pengeluaran_part_tipe_id"));
    }
    public function getStatusNsc()
    {
        return $this->hasOne(\app\models\StatusNsc::className(), array("id" => "status_nsc_id"));
    }
    public function getPengeluaranPartDetails()
    {
        return $this->hasMany(\app\models\PengeluaranPartDetail::className(), array("pengeluaran_part_id" => "id"));
    }
}

?>