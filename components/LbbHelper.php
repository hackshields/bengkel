<?php

namespace app\components;

class LbbHelper
{
    public static $tanggal_1 = NULL;
    public static $tanggal_2 = NULL;
    public static $tanggal_ori_1 = NULL;
    public static $tanggal_ori_2 = NULL;
    private static $jasaGroupID = NULL;
    public static $oli = NULL;
    public static $mekanikID = NULL;
    public static function setDate($date_1, $date_2)
    {
        self::$tanggal_1 = $date_1 . " 00:00:00";
        self::$tanggal_2 = $date_2 . " 23:59:59";
        self::$tanggal_ori_1 = $date_1;
        self::$tanggal_ori_2 = $date_2;
    }
    private static function getDateDiff()
    {
        $now = strtotime(self::$tanggal_2);
        $your_date = strtotime(self::$tanggal_1);
        $datediff = $now - $your_date;
        return floor($datediff / (60 * 60 * 24));
    }
    public static function getTotalEntryKPB()
    {
        $detail = \app\models\NotaJasaDetail::find()->joinWith(array("notaJasa" => function ($pQuery) {
            $pQuery->where("tanggal_njb between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->andWhere(array("nota_jasa.jaringan_id" => \app\models\Jaringan::getCurrentID(), "status_njb_id" => \app\models\StatusNjb::CLOSE));
        }))->joinWith(array("jasa" => function ($sQuery) {
            $sQuery->where(array("jasa_group_id" => array(\app\models\JasaGroup::ASS1, \app\models\JasaGroup::ASS2, \app\models\JasaGroup::ASS3, \app\models\JasaGroup::ASS4)));
        }))->select("sum(nota_jasa_detail.total) as total")->one();
        $njb = intval($detail->total);
        return $njb;
    }
    public static function getTotalEntryJasa($jasaGroupID)
    {
        self::$jasaGroupID = $jasaGroupID;
        $detail = \app\models\NotaJasaDetail::find()->joinWith(array("notaJasa" => function ($pQuery) {
            $pQuery->where("tanggal_njb between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->andWhere(array("nota_jasa.jaringan_id" => \app\models\Jaringan::getCurrentID(), "status_njb_id" => \app\models\StatusNjb::CLOSE));
        }))->joinWith(array("jasa" => function ($sQuery) {
            $sQuery->where(array("jasa_group_id" => self::$jasaGroupID));
        }))->select("sum(nota_jasa_detail.total) as total")->one();
        $njb = intval($detail->total);
        return $njb;
    }
    public static function getTotalServiceSparePart()
    {
        self::$oli = \app\models\SukuCadangGroup::find()->where(array("kode" => "OLI"))->one();
        $detail = \app\models\PengeluaranPartDetail::find()->joinWith(array("pengeluaranPart" => function ($pQuery) {
            $pQuery->where("tanggal_pengeluaran between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->andWhere(array("pengeluaran_part.jaringan_id" => \app\models\Jaringan::getCurrentID(), "status_nsc_id" => array(\app\models\StatusNsc::CLOSE)))->andWhere("pengeluaran_part.no_referensi is not null");
        }))->joinWith(array("sukuCadang" => function ($sQuery) {
            $sQuery->where("suku_cadang_group_id != " . self::$oli->id);
        }))->select("sum(pengeluaran_part_detail.total) as total")->one();
        return intval($detail->total);
    }
    public static function getTotalServiceOli()
    {
        self::$oli = \app\models\SukuCadangGroup::find()->where(array("kode" => "OLI"))->one();
        $detail = \app\models\PengeluaranPartDetail::find()->joinWith(array("pengeluaranPart" => function ($pQuery) {
            $pQuery->where("tanggal_pengeluaran between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->andWhere(array("pengeluaran_part.jaringan_id" => \app\models\Jaringan::getCurrentID(), "status_nsc_id" => array(\app\models\StatusNsc::CLOSE)))->andWhere("pengeluaran_part.no_referensi is not null");
        }))->joinWith(array("sukuCadang" => function ($sQuery) {
            $sQuery->where("suku_cadang_group_id = " . self::$oli->id);
        }))->select("sum(pengeluaran_part_detail.total) as total")->one();
        return intval($detail->total);
    }
    public static function getTotalEntryPengeluaranPart()
    {
        self::$oli = \app\models\SukuCadangGroup::find()->where(array("kode" => "OLI"))->one();
        $pengeluaran = \app\models\PengeluaranPartDetail::find()->joinWith(array("pengeluaranPart" => function ($pQuery) {
            $pQuery->where("tanggal_pengeluaran between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->andWhere(array("pengeluaran_part.jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("pengeluaran_part.no_referensi is null");
        }))->joinWith(array("sukuCadang" => function ($sQuery) {
            $sQuery->where("suku_cadang_group_id != " . self::$oli->id);
        }))->select("sum(pengeluaran_part_detail.total) as total")->one();
        return intval($pengeluaran->total);
    }
    public static function getTotalEntryPengeluaranOli()
    {
        self::$oli = \app\models\SukuCadangGroup::find()->where(array("kode" => "OLI"))->one();
        $pengeluaran = \app\models\PengeluaranPartDetail::find()->joinWith(array("pengeluaranPart" => function ($pQuery) {
            $pQuery->where("tanggal_pengeluaran between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->andWhere(array("pengeluaran_part.jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("pengeluaran_part.no_referensi is null");
        }))->joinWith(array("sukuCadang" => function ($sQuery) {
            $sQuery->where("suku_cadang_group_id = " . self::$oli->id);
        }))->select("sum(pengeluaran_part_detail.total) as total")->one();
        return intval($pengeluaran->total);
    }
    public static function getMekanikUnitService($mekanik_id)
    {
        return \app\models\PerintahKerja::find()->where(array("karyawan_id" => $mekanik_id, "jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("waktu_daftar between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->count();
    }
    public static function getMekanikTidakHadir($mekanik_id)
    {
        return \app\models\Absensi::find()->where(array("karyawan_id" => $mekanik_id, "jaringan_id" => \app\models\Jaringan::getCurrentID(), "absensi_status_id" => array(\app\models\AbsensiStatus::IZIN, \app\models\AbsensiStatus::SAKIT, \app\models\AbsensiStatus::CUTI, \app\models\AbsensiStatus::ALPA)))->andWhere("jam_masuk between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->count();
    }
    public static function getMekanikHadir($mekanik_id)
    {
        return \app\models\Absensi::find()->where(array("karyawan_id" => $mekanik_id, "jaringan_id" => \app\models\Jaringan::getCurrentID(), "absensi_status_id" => \app\models\AbsensiStatus::MASUK))->andWhere("jam_masuk between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->count();
    }
    public static function getPresensi($mekanik_id)
    {
        $tanggalAwal = strtotime(self::$tanggal_ori_1);
        $tanggalAkhir = strtotime(self::$tanggal_ori_2);
        $presensi = array("hadir" => 0, "absen" => 0);
        $i = $tanggalAwal;
        while ($i <= $tanggalAkhir) {
            $d = date("Y-m-d", $i);
            $absensi = \app\models\Absensi::find()->where(array("karyawan_id" => $mekanik_id, "jaringan_id" => \app\models\Jaringan::getCurrentID(), "absensi_status_id" => \app\models\AbsensiStatus::MASUK))->andWhere("jam_masuk between '" . $d . " 00:00:00' AND '" . $d . " 23:59:59'")->one();
            if ($absensi) {
                $presensi["hadir"] += 1;
            } else {
                $presensi["absen"] += 1;
            }
            $i += 3600 * 24;
        }
        return $presensi;
    }
    public static function getMekanikJamTersedia($mekanik_id)
    {
        $totalWaktu = 0;
        $perintahKerjaArr = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => array(\app\models\PerintahKerjaStatus::SELESAI, \app\models\PerintahKerjaStatus::NOTA), "karyawan_id" => $mekanik_id))->andWhere("waktu_daftar between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->select(array("sum(durasi_service) as durasi_service"))->all();
        foreach ($perintahKerjaArr as $perintahKerja) {
            $totalWaktu += 8;
        }
        return $totalWaktu;
    }
    public static function getMekanikJamTerpakai($mekanik_id)
    {
        $totalWaktu = 0;
        $perintahKerjaArr = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => array(\app\models\PerintahKerjaStatus::SELESAI, \app\models\PerintahKerjaStatus::NOTA), "karyawan_id" => $mekanik_id))->andWhere("waktu_daftar between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->select(array("sum(durasi_service) as durasi_service"))->all();
        foreach ($perintahKerjaArr as $perintahKerja) {
            if ($perintahKerja->waktu_pause != null) {
                $waktu = strtotime($perintahKerja->waktu_selesai) - strtotime($perintahKerja->waktu_resume) + strtotime($perintahKerja->waktu_pause) - strtotime($perintahKerja->waktu_daftar);
            } else {
                $waktu = strtotime($perintahKerja->waktu_selesai) - strtotime($perintahKerja->waktu_daftar);
            }
            $totalWaktu += $waktu;
        }
        return $totalWaktu / 3600;
    }
    public static function getMekanikJasa($mekanik_id, $jasaGroupId)
    {
        self::$jasaGroupID = $jasaGroupId;
        self::$mekanikID = $mekanik_id;
        $detail = \app\models\NotaJasaDetail::find()->joinWith(array("notaJasa" => function ($pQuery) {
            $pQuery->where("tanggal_njb between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->andWhere(array("nota_jasa.jaringan_id" => \app\models\Jaringan::getCurrentID(), "karyawan_id" => self::$mekanikID, "status_njb_id" => \app\models\StatusNjb::CLOSE));
        }))->joinWith(array("jasa" => function ($sQuery) {
            $sQuery->where(array("jasa_group_id" => self::$jasaGroupID));
        }))->count();
        $njb = intval($detail);
        return $njb;
    }
}

?>