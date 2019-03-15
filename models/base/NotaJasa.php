<?php

namespace app\models\base;

class NotaJasa extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "nota_jasa";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "nomor", "karyawan_id"), "required"), array(array("jaringan_id", "perintah_kerja_id", "karyawan_id", "nomor_cetak", "status_njb_id", "total", "approved_by", "status_pembayaran_id", "tunai_nominal", "debit_nominal", "created_by", "updated_by"), "integer"), array(array("tanggal_njb", "tanggal_jt", "tanggal_batal", "tanggal_bayar", "created_at", "updated_at"), "safe"), array(array("keterangan_batal"), "string"), array(array("nomor", "no_batal"), "string", "max" => 20), array(array("catatan"), "string", "max" => 200), array(array("debit_terminal", "debit_bank", "debit_no_kartu", "debit_pemilik", "debit_approval_code"), "string", "max" => 50), array(array("bukti_bayar", "bank_bayar"), "string", "max" => 30));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "nomor" => "Nomor", "perintah_kerja_id" => "Perintah Kerja ID", "karyawan_id" => "Karyawan ID", "tanggal_njb" => "Tanggal Njb", "tanggal_jt" => "Tanggal Jt", "catatan" => "Catatan", "nomor_cetak" => "Nomor Cetak", "status_njb_id" => "Status Njb ID", "total" => "Total", "no_batal" => "No Batal", "keterangan_batal" => "Keterangan Batal", "tanggal_batal" => "Tanggal Batal", "approved_by" => "Approved By", "status_pembayaran_id" => "Status Pembayaran ID", "tunai_nominal" => "Tunai Nominal", "debit_nominal" => "Debit Nominal", "debit_terminal" => "Debit Terminal", "debit_bank" => "Debit Bank", "debit_no_kartu" => "Debit No Kartu", "debit_pemilik" => "Debit Pemilik", "debit_approval_code" => "Debit Approval Code", "tanggal_bayar" => "Tanggal Bayar", "created_at" => "Created At", "bukti_bayar" => "Bukti Bayar", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By", "bank_bayar" => "Bank Bayar");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getStatusNjb()
    {
        return $this->hasOne(\app\models\StatusNjb::className(), array("id" => "status_njb_id"));
    }
    public function getApprovedBy()
    {
        return $this->hasOne(\app\models\Karyawan::className(), array("id" => "approved_by"));
    }
    public function getStatusPembayaran()
    {
        return $this->hasOne(\app\models\StatusPembayaran::className(), array("id" => "status_pembayaran_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getPerintahKerja()
    {
        return $this->hasOne(\app\models\PerintahKerja::className(), array("id" => "perintah_kerja_id"));
    }
    public function getKaryawan()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "karyawan_id"));
    }
    public function getNotaJasaDetails()
    {
        return $this->hasMany(\app\models\NotaJasaDetail::className(), array("nota_jasa_id" => "id"));
    }
}

?>