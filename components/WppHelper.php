<?php

namespace app\components;

class WppHelper
{
    public static $tanggal_1 = NULL;
    public static $tanggal_2 = NULL;
    public static $tanggal_ori_1 = NULL;
    public static $tanggal_ori_2 = NULL;
    private static $jasaGroupID = NULL;
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
    public static function getTotalPengeluaran()
    {
        $penerimaan = \app\models\PenerimaanPart::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "penerimaan_part_tipe_id" => \app\models\PenerimaanPartTipe::PEMBELIAN, "pembayaran_id" => array(\app\models\Pembayaran::CASH, \app\models\Pembayaran::REGULAR)))->andWhere("tanggal_penerimaan between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->select(array("sum(total) as total"))->one();
        return intval($penerimaan->total);
    }
    public static function getTotalJasa()
    {
        $notaJasa = \app\models\NotaJasa::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "status_njb_id" => \app\models\StatusNjb::CLOSE, "status_pembayaran_id" => \app\models\StatusPembayaran::CLOSE))->andWhere("tanggal_njb between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->select(array("sum(total) as total"))->one();
        return intval($notaJasa->total);
    }
    public static function getTotalPart()
    {
        $pengeluaranPart = \app\models\PengeluaranPart::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "status_nsc_id" => \app\models\StatusNsc::CLOSE))->andWhere("tanggal_pengeluaran between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->select(array("sum(total) as total"))->one();
        return intval($pengeluaranPart->total);
    }
    public static function getJumlahMekanikProduktif()
    {
        return \app\models\User::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "role_id" => \app\models\Role::MEKANIK, "status" => 1))->count();
    }
    public static function getJumlahJamTerpakaiMekanik()
    {
        $perintahKerja = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => array(\app\models\PerintahKerjaStatus::SELESAI, \app\models\PerintahKerjaStatus::NOTA)))->andWhere("created_at between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->select(array("sum(durasi_service) as durasi_service"))->one();
        return intval($perintahKerja->durasi_service) / 60;
    }
    public static function getJumlahHariAktif()
    {
        $tanggal1 = date("Y-m-d", strtotime(self::$tanggal_1));
        $tanggal2 = date("Y-m-d", strtotime(self::$tanggal_2));
        return \app\models\HariAktif::find()->where("tanggal >= '" . $tanggal1 . "' AND tanggal <= '" . $tanggal2 . "'")->andWhere(array("jaringan_id" => \app\models\Jaringan::getCurrentID()))->count();
    }
    public static function getJumlahJamTersediaMekanik()
    {
        $jmlHari = self::getJumlahHariAktif();
        return self::getJumlahMekanikProduktif() * 7 * $jmlHari;
    }
    public static function getJumlahPekerjaanDiulang()
    {
        return \app\models\PerintahKerja::find()->joinWith(array("perintahKerjaJasas" => function ($queryPkj) {
            $queryPkj->joinWith(array("jasa" => function ($queryJasa) {
                $queryJasa->where(array("jasa_group_id" => \app\models\JasaGroup::JR));
            }));
        }))->where(array("perintah_kerja.jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => array(\app\models\PerintahKerjaStatus::SELESAI, \app\models\PerintahKerjaStatus::NOTA)))->andWhere("perintah_kerja.waktu_daftar between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->count();
    }
    public static function getJumlahPekerjaanTotal()
    {
        return \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => array(\app\models\PerintahKerjaStatus::SELESAI, \app\models\PerintahKerjaStatus::NOTA)))->andWhere("waktu_daftar between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->count();
    }
    public static function getJumlahHariAbsenMekanik()
    {
        return \app\models\Absensi::find()->where(array("absensi.jaringan_id" => \app\models\Jaringan::getCurrentID(), "absensi_status_id" => \app\models\AbsensiStatus::MASUK))->joinWith(array("karyawan" => function ($queryKaryawan) {
            $queryKaryawan->where(array("role_id" => \app\models\Role::MEKANIK));
        }))->andWhere("jam_masuk between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->count();
    }
    public static function getJumlahPelangganBaru()
    {
        return \app\models\Konsumen::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("created_at between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->count();
    }
    public static function getJumlahPelanggan()
    {
        $pelanggan = array("lama" => 0, "baru" => 0, "total" => 0);
        $pkbList = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => \app\models\PerintahKerjaStatus::NOTA))->andWhere("waktu_daftar between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->all();
        foreach ($pkbList as $pkb) {
            $konsumen = $pkb->konsumen;
            if ($konsumen->service_terakhir == $konsumen->created_at) {
                $pelanggan["baru"] += 1;
            } else {
                $pelanggan["lama"] += 1;
            }
            $pelanggan["total"] += 1;
        }
        return $pelanggan;
    }
    public static function getJumlahPelangganTerkontrol()
    {
        $waktu3BulanLalu = date("Y-m-d H:i:s", strtotime(self::$tanggal_2 . " -3 month"));
        return \app\models\Konsumen::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("service_terakhir between '" . $waktu3BulanLalu . "' AND '" . self::$tanggal_2 . "'")->count();
    }
    public static function getJumlahPelanggan2TahunKeBelakang()
    {
        $waktu2TahunLalu = date("Y-m-d H:i:s", strtotime(self::$tanggal_2 . " -2 years"));
        return \app\models\Konsumen::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("created_at between '" . $waktu2TahunLalu . "' AND '" . self::$tanggal_2 . "'")->count();
    }
    public static function getTotalPartTidakTersedia()
    {
        $output = 0;
        $kosong = \app\models\SukuCadangKosong::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()))->andWhere("created_at between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->all();
        foreach ($kosong as $item) {
            $output += $item->sukuCadang->het;
        }
        return $output;
    }
    public static function getTotalPenjualanPart()
    {
        $pengeluaranPart = \app\models\PengeluaranPart::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "status_nsc_id" => \app\models\StatusNsc::CLOSE))->andWhere("tanggal_pengeluaran between '" . self::$tanggal_ori_1 . "' AND '" . self::$tanggal_ori_2 . "'")->select(array("sum(total) as total"))->one();
        return intval($pengeluaranPart->total);
    }
    public static function getTotalEntryKPB()
    {
        $jumlah = 0;
        $jasaGroups = array(\app\models\JasaGroup::ASS1, \app\models\JasaGroup::ASS2, \app\models\JasaGroup::ASS3, \app\models\JasaGroup::ASS4);
        $pkbList = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => \app\models\PerintahKerjaStatus::NOTA))->andWhere("waktu_daftar between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->all();
        foreach ($pkbList as $perintahKerja) {
            $notaJasas = $perintahKerja->notaJasas;
            foreach ($notaJasas as $notaJasa) {
                $kpbExist = false;
                foreach ($notaJasa->notaJasaDetails as $detail) {
                    if (in_array($detail->jasa->jasa_group_id, $jasaGroups)) {
                        $kpbExist = true;
                        break;
                    }
                }
                if ($kpbExist) {
                    $jumlah += 1;
                }
            }
        }
        return $jumlah;
    }
    public static function getTotalEntryNonKPB()
    {
        $jumlah = 0;
        $jasaGroups = array(\app\models\JasaGroup::CL, \app\models\JasaGroup::GO, \app\models\JasaGroup::HR, \app\models\JasaGroup::JR, \app\models\JasaGroup::LR, \app\models\JasaGroup::PL, \app\models\JasaGroup::PR);
        $pkbList = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_status_id" => \app\models\PerintahKerjaStatus::NOTA))->andWhere("waktu_daftar between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->all();
        foreach ($pkbList as $perintahKerja) {
            $notaJasas = $perintahKerja->notaJasas;
            foreach ($notaJasas as $notaJasa) {
                $kpbExist = false;
                foreach ($notaJasa->notaJasaDetails as $detail) {
                    if (in_array($detail->jasa->jasa_group_id, $jasaGroups)) {
                        $kpbExist = true;
                        break;
                    }
                }
                if ($kpbExist) {
                    $jumlah += 1;
                }
            }
        }
        return $jumlah;
    }
    public static function getTotalEntryJasa($jasaGroupID)
    {
        self::$jasaGroupID = $jasaGroupID;
        $jumlah = \app\models\NotaJasa::find()->where(array("nota_jasa.jaringan_id" => \app\models\Jaringan::getCurrentID(), "status_njb_id" => \app\models\StatusNjb::CLOSE, "status_pembayaran_id" => \app\models\StatusPembayaran::CLOSE))->andWhere("nota_jasa.created_at between '" . self::$tanggal_1 . "' AND '" . self::$tanggal_2 . "'")->joinWith(array("notaJasaDetails" => function ($queryNJDetail) {
            $queryNJDetail->joinWith(array("jasa" => function ($qJasa) {
                $qJasa->where(array("jasa_group_id" => self::$jasaGroupID));
            }));
        }))->count();
        return intval($jumlah);
    }
}

?>