<?php

namespace app\models;

class PerintahKerja extends base\PerintahKerja
{
    public static function getCurrentActive()
    {
        return PerintahKerja::find()->where(array("jaringan_id" => Jaringan::getCurrentID()))->all();
    }
    public function fields()
    {
        return array("id", "jaringan_id", "perintah_kerja_tipe_id", "perintah_kerja_tipe_nama" => function ($model) {
            return $model->perintahKerjaTipe->nama;
        }, "nomor", "tanggal_ass", "no_antrian", "perintah_kerja_alasan_id", "konsumen_id", "konsumen", "konsumen_nama" => function ($model) {
            return $model->konsumen->nama_identitas;
        }, "konsumen_alamat" => function ($model) {
            return $model->konsumen->alamat;
        }, "konsumen_kota" => function ($model) {
            return $model->konsumen->wilayahKabupaten->nama;
        }, "konsumen_nopol" => function ($model) {
            return $model->konsumen->nopol;
        }, "motor_id" => function ($model) {
            return $model->konsumen->motor_id;
        }, "konsumen_motor" => function ($model) {
            $motor = $model->konsumen->motor;
            if ($motor) {
                return $motor->getNamaLengkap();
            }
            return "(No Data)";
        }, "karyawan_id", "karyawan_nama" => function ($model) {
            return $model->karyawan->name;
        }, "karyawan", "kondisi_awal", "keluhan", "analisa", "km", "bbm", "konfirmasi", "dari_sms", "catatan", "waktu_daftar", "waktu_daftar_date" => function ($model) {
            return \app\components\Tanggal::toReadableDate($model->waktu_daftar, false, true);
        }, "waktu_daftar_time" => function ($model) {
            return $model->waktu_daftar == null ? "" : date("H:i", strtotime($model->waktu_daftar));
        }, "waktu_kerja", "waktu_kerja_time" => function ($model) {
            return $model->waktu_kerja == null ? "" : date("H:i", strtotime($model->waktu_kerja));
        }, "waktu_selesai", "waktu_selesai_time" => function ($model) {
            return $model->waktu_selesai == null ? "" : date("H:i", strtotime($model->waktu_selesai));
        }, "waktu_pause", "waktu_resume", "durasi_service", "jumlah_tunggu_menit", "perintah_kerja_status_id", "perintah_kerja_status_nama" => function ($model) {
            return $model->perintahKerjaStatus->nama;
        }, "status_njb_id", "status_nsc_id", "total" => function ($model) {
            $harga = 0;
            foreach ($model->perintahKerjaJasas as $detail) {
                $harga += $detail->total;
            }
            foreach ($model->perintahKerjaSukuCadangs as $detail) {
                $harga += $detail->total;
            }
            return $harga;
        }, "action" => function ($model) {
            return \yii\helpers\Html::button("Gunakan", array("class" => "btn-pkb-gunakan", "data_id" => $model->id));
        }, "action_koreksi" => function ($model) {
            return \yii\helpers\Html::button("Edit", array("class" => "btn-edit", "data_id" => $model->id));
        });
    }
    public function beforeSave($insert)
    {
        if ($this->waktu_selesai != null && $this->waktu_daftar != null) {
            if ($this->waktu_pause != null && $this->waktu_resume != null) {
                $this->durasi_service = intval((strtotime($this->waktu_selesai) - strtotime($this->waktu_resume) + strtotime($this->waktu_pause) - strtotime($this->waktu_daftar)) / 60);
            } else {
                $this->durasi_service = intval((strtotime($this->waktu_selesai) - strtotime($this->waktu_daftar)) / 60);
            }
        }
        if ($this->tanggal_ass == null) {
            $this->tanggal_ass = date("Y-m-d", strtotime($this->waktu_daftar));
        }
        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
            $this->created_by = \Yii::$app->user->id;
        } else {
            $this->updated_at = date("Y-m-d H:i:s");
            $this->updated_by = \Yii::$app->user->id;
        }
        $this->is_need_update = 1;
        if (\Yii::$app->user->isGuest) {
            BreachLog::addLog();
            return false;
        }
        return true;
    }
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = self::find()->where(array("nomor" => $kode, "jaringan_id" => Jaringan::getCurrentID()))->one();
        if ($kGroup) {
            return $kGroup->id;
        }
        return null;
    }
}

?>