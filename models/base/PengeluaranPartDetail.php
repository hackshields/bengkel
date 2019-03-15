<?php

namespace app\models\base;

class PengeluaranPartDetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "pengeluaran_part_detail";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "pengeluaran_part_id", "suku_cadang_id", "beban_pembayaran_id"), "required"), array(array("jaringan_id", "pengeluaran_part_id", "suku_cadang_id", "rak_id", "harga_jual", "hpp", "quantity", "diskon_r", "total", "beban_pembayaran_id", "status_terima_mekanik", "mekanik_penerima_id", "created_by", "updated_by", "online_id", "is_need_update"), "integer"), array(array("diskon_p"), "number"), array(array("created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan", "pengeluaran_part_id" => "Pengeluaran Part", "suku_cadang_id" => "Suku Cadang", "rak_id" => "Rak", "harga_jual" => "Harga Jual", "hpp" => "HPP", "quantity" => "Quantity", "diskon_p" => "Diskon(%)", "diskon_r" => "Diskon(Rp)", "total" => "Total", "beban_pembayaran_id" => "Beban Pembayaran", "status_terima_mekanik" => "Status Terima Mekanik", "mekanik_penerima_id" => "Mekanik Penerima", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By", "online_id" => "Online ID", "is_need_update" => "Is Need Update");
    }
    public function getPengeluaranPart()
    {
        return $this->hasOne(\app\models\PengeluaranPart::className(), array("id" => "pengeluaran_part_id"));
    }
    public function getSukuCadang()
    {
        return $this->hasOne(\app\models\SukuCadang::className(), array("id" => "suku_cadang_id"));
    }
    public function getRak()
    {
        return $this->hasOne(\app\models\Rak::className(), array("id" => "rak_id"));
    }
    public function getMekanikPenerima()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "mekanik_penerima_id"));
    }
    public function getBebanPembayaran()
    {
        return $this->hasOne(\app\models\BebanPembayaran::className(), array("id" => "beban_pembayaran_id"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
}

?>