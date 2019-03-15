<?php

namespace app\controllers;

class BengkelPenerimaanServiceController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public $pkb = NULL;
    public $konsumen_id = NULL;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionListPekerjaan()
    {
        $query = \app\models\PerintahKerja::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "date(waktu_daftar)" => date("Y-m-d"), "perintah_kerja_status_id" => array(\app\models\PerintahKerjaStatus::TUNGGU, \app\models\PerintahKerjaStatus::DIKERJAKAN, \app\models\PerintahKerjaStatus::SELESAI, \app\models\PerintahKerjaStatus::TUNDA, \app\models\PerintahKerjaStatus::NOTA), "nomor_cetak" => 0));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionSavePekerjaan($id = NULL)
    {
        if ($id == null) {
            $max = \app\models\PerintahKerja::find()->select("max(id) as id")->one();
            $jml = \app\models\PerintahKerja::find()->where(array("year(waktu_daftar)" => date("Y"), "month(waktu_daftar)" => date("n")))->count();
            $user = \Yii::$app->user->identity;
            $pen = new \app\models\PerintahKerja();
            $pen->jaringan_id = $user->jaringan_id;
            $pen->nomor = date("Ymd") . ($max + 1) . "PKB" . str_pad($jml + 1, 3, "0", STR_PAD_LEFT);
            $pen->karyawan_id = $user->id;
        } else {
            $pen = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        }
        $pen->no_antrian = $_POST["no_antrian"];
        $pen->perintah_kerja_alasan_id = $_POST["perintah_kerja_alasan_id"];
        $pen->waktu_daftar = date("Y-m-d H:i:s");
        $pen->konsumen_id = $_POST["konsumen_id"];
        $pen->kondisi_awal = $_POST["kondisi_awal"];
        $pen->keluhan = $_POST["keluhan"];
        $pen->analisa = $_POST["analisa"];
        $pen->km = $_POST["km"];
        $pen->bbm = $_POST["bbm"];
        $pen->konfirmasi = $_POST["konfirmasi"];
        $pen->catatan = $_POST["catatan"];
        $pen->perintah_kerja_tipe_id = 1;
        $pen->perintah_kerja_status_id = 1;
        if ($pen->save()) {
            if ($pen->konsumen_id != null) {
                $konsumen = $pen->konsumen;
                $konsumen->motor_id = $_POST["motor_id"];
                $konsumen->no_telepon = $_POST["konsumen_no_telepon"];
                $konsumen->save();
            }
            if (date("Y-m-d", strtotime($pen->konsumen->created_at)) != date("Y-m-d")) {
                $pen->konsumen->service_terakhir = date("Y-m-s H:i:s");
            }
            $pen->konsumen->save();
        }
        return \app\components\AjaxResponse::send($pen);
    }
    public function actionDeletePekerjaan($id)
    {
        $model = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        foreach ($model->perintahKerjaCheckpoints as $checkpoint) {
            $checkpoint->delete();
        }
        foreach ($model->perintahKerjaJasas as $checkpoint) {
            $checkpoint->delete();
        }
        foreach ($model->perintahKerjaSukuCadangs as $checkpoint) {
            $checkpoint->delete();
        }
        $model->delete();
    }
    public function actionDetailPointPemeriksaan($id = NULL)
    {
        $query = \app\models\PerintahKerjaCheckpoint::find()->where(array("perintah_kerja_id" => $id));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionDetailJasaService($id = NULL)
    {
        $query = \app\models\PerintahKerjaJasa::find()->where(array("perintah_kerja_id" => $id));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionDetailSukuCadang($id = NULL)
    {
        $query = \app\models\PerintahKerjaSukuCadang::find()->where(array("perintah_kerja_id" => $id));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionDetailProsesPembayaran($id = NULL)
    {
        $query = \app\models\PerintahKerjaSukuCadang::find()->where(array("perintah_kerja_id" => $id));
    }
    public function actionInfoDetailSukucadang($id)
    {
        $model = \app\models\PerintahKerjaSukuCadang::find()->where(array("id" => $id))->one();
        return \app\components\AjaxResponse::send($model);
    }
    public function actionInfoDetailJasa($id)
    {
        $model = \app\models\PerintahKerjaJasa::find()->where(array("id" => $id))->one();
        return \app\components\AjaxResponse::send($model);
    }
    public function actionDetailHistorikalService($id = NULL)
    {
        if ($id == null) {
            $query = \app\models\NotaJasaDetail::find()->where("id is null");
        } else {
            $this->pkb = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
            $query = \app\models\NotaJasaDetail::find()->joinWith(array("notaJasa" => function ($qHeader) {
                $qHeader->joinWith(array("perintahKerja" => function ($qqHeader) {
                    $qqHeader->where(array("perintah_kerja.konsumen_id" => $this->pkb->konsumen_id));
                }));
                $qHeader->andWhere(array("nota_jasa.jaringan_id" => \app\models\Jaringan::getCurrentID()));
            }));
        }
        return \app\components\DataGridUtility::process($query);
    }
    public function actionDetailHistorikalParts($id = NULL)
    {
        if ($id == null) {
            $query = \app\models\PengeluaranPartDetail::find()->where("id is null");
        } else {
            $pkb = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
            $this->konsumen_id = $pkb->konsumen_id;
            $query = \app\models\PengeluaranPartDetail::find()->joinWith(array("pengeluaranPart" => function ($qHeader) {
                $qHeader->where(array("pengeluaran_part.konsumen_id" => $this->konsumen_id, "pengeluaran_part.jaringan_id" => \app\models\Jaringan::getCurrentID()));
            }));
        }
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListKonsumen()
    {
        $query = \app\models\Konsumen::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionNopolCombo($id)
    {
        $output = array();
        foreach (\app\models\Konsumen::find()->where(array("id" => $id))->all() as $kab) {
            $output[] = array("value" => $kab->id, "text" => $kab->nopol . " - " . $kab->nama_identitas);
        }
        return \yii\helpers\Json::encode($output);
    }
    public function actionListJasa()
    {
        $query = \app\models\Jasa::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "status" => 1));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListSukuCadang()
    {
        $query = \app\models\SukuCadang::find();
        return \app\components\DataGridUtility::process($query);
    }
    public function actionAddDetailJasa()
    {
        $jasa_id = $_POST["jasa_id"];
        $perintah_kerja_id = $_POST["perintah_kerja_id"];
        $jasa = \app\models\Jasa::find()->where(array("id" => $jasa_id))->one();
        $pkbDuplikat = \app\models\PerintahKerjaJasa::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_id" => $perintah_kerja_id, "jasa_id" => $jasa_id))->one();
        $perintahKerja = null;
        $pen = new \app\models\PerintahKerjaJasa();
        $pen->jaringan_id = \app\models\Jaringan::getCurrentID();
        $pen->jasa_id = $jasa_id;
        $pen->perintah_kerja_id = $perintah_kerja_id;
        $pen->harga = $jasa->harga;
        $pen->total = $jasa->harga;
        $pen->diskon_p = 0;
        $pen->diskon_r = 0;
        $pen->dpph = 0;
        $pen->dpp = 0;
        $pen->pph = 0;
        $pen->ppn = 0;
        $pen->operasional = 0;
        $pen->beban_pembayaran_id = \app\models\BebanPembayaran::CASH;
        if ($pkbDuplikat == null) {
            $pen->save();
            $perintahKerja = $pen->perintahKerja;
        } else {
            $perintahKerja = $pen->perintahKerja;
            $perintahKerja->addError("jasa_id", "Jasa yang Anda masukan sudah ada.");
        }
        return \app\components\AjaxResponse::send($perintahKerja);
    }
    public function actionAddDetailSukucadang()
    {
        $message = "Suku cadang berhasil ditambahkan.";
        $suku_cadang_id = $_POST["suku_cadang_id"];
        $perintah_kerja_id = $_POST["perintah_kerja_id"];
        $sukuCadang = \app\models\SukuCadang::find()->where(array("id" => $suku_cadang_id))->one();
        $sukuCadangJaringan = $sukuCadang->getSukuCadangJaringan();
        $pkbDuplikat = \app\models\PerintahKerjaSukuCadang::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "perintah_kerja_id" => $perintah_kerja_id, "suku_cadang_id" => $suku_cadang_id))->one();
        $perintahKerja = null;
        $pen = new \app\models\PerintahKerjaSukuCadang();
        $pen->jaringan_id = \app\models\Jaringan::getCurrentID();
        $pen->suku_cadang_id = $suku_cadang_id;
        $pen->perintah_kerja_id = $perintah_kerja_id;
        $pen->quantity = 1;
        $pen->harga = $sukuCadangJaringan->harga_jual;
        $pen->total = $sukuCadangJaringan->harga_jual;
        $pen->diskon_p = 0;
        $pen->diskon_r = 0;
        $pen->rak_id = null;
        $pen->hpp = $sukuCadangJaringan->hpp;
        $pen->beban_pembayaran_id = \app\models\BebanPembayaran::CASH;
        if ($pkbDuplikat == null) {
            $pen->save();
            $perintahKerja = $pen->perintahKerja;
        } else {
            $perintahKerja = $pen->perintahKerja;
            $perintahKerja->addError("suku_cadang_id", "Suku cadang yang Anda masukan sudah ada.");
        }
        $stokKosong = false;
        if ($sukuCadangJaringan != null) {
            if ($sukuCadangJaringan->quantity <= 0) {
                $stokKosong = true;
            }
        } else {
            $stokKosong = true;
        }
        if ($stokKosong) {
            $message = "Stok barang '" . $sukuCadang->nama . "' kosong, otomatis memasukkan ke dalam stok barang kosong.";
            $kosong = \app\models\SukuCadangKosong::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID(), "suku_cadang_id" => $suku_cadang_id))->one();
            if ($kosong == null) {
                $kosong = new \app\models\SukuCadangKosong();
                $kosong->jaringan_id = \app\models\Jaringan::getCurrentID();
                $kosong->suku_cadang_id = $suku_cadang_id;
                $kosong->jumlah = 0;
            }
            $kosong->jumlah += 1;
            $kosong->save();
            $pen->delete();
        }
        return \app\components\AjaxResponse::send($perintahKerja, $message);
    }
    public function actionSaveDetailJasa($id)
    {
        $pen = \app\models\PerintahKerjaJasa::find()->where(array("id" => $id))->one();
        $pen->harga = $_POST["harga"];
        $pen->diskon_p = $_POST["diskon_p"];
        $pen->diskon_r = $_POST["diskon_r"];
        $pen->total = $_POST["total"];
        $pen->beban_pembayaran_id = $_POST["beban_pembayaran_id"];
        $pen->save();
        return \app\components\AjaxResponse::send($pen);
    }
    public function actionSaveDetailSukucadang($id)
    {
        $pen = \app\models\PerintahKerjaSukuCadang::find()->where(array("id" => $id))->one();
        $pen->quantity = $_POST["quantity"];
        $pen->harga = $_POST["harga"];
        $pen->diskon_p = $_POST["diskon_p"];
        $pen->diskon_r = $_POST["diskon_r"];
        $pen->total = $_POST["total"];
        $pen->beban_pembayaran_id = $_POST["beban_pembayaran_id"];
        $pen->save();
        return \app\components\AjaxResponse::send($pen);
    }
    public function actionDeleteDetailJasa($id)
    {
        $model = \app\models\PerintahKerjaJasa::find()->where(array("id" => $id))->one();
        $model->delete();
        return \app\components\AjaxResponse::send($model);
    }
    public function actionDeleteDetailSukucadang($id)
    {
        $model = \app\models\PerintahKerjaSukuCadang::find()->where(array("id" => $id))->one();
        $model->delete();
        return \app\components\AjaxResponse::send($model);
    }
    public function actionLoad($id)
    {
        $model = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        return \yii\helpers\Json::encode($model);
    }
    public function actionLoadKonsumen($id)
    {
        $model = \app\models\Konsumen::find()->where(array("id" => $id))->one();
        return \yii\helpers\Json::encode($model);
    }
    public function actionKerjakan($id, $mekanik_id)
    {
        $model = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        if (count($model->perintahKerjaJasas) != 0) {
            $model->perintah_kerja_status_id = \app\models\PerintahKerjaStatus::DIKERJAKAN;
            $model->karyawan_id = $mekanik_id;
            $model->waktu_kerja = date("Y-m-d H:i:s");
            $model->save();
            $user = \app\models\User::find()->where(array("id" => $mekanik_id))->one();
            $user->is_on_duty = 1;
            $user->save();
            return \yii\helpers\Json::encode($model);
        }
        \Yii::$app->response->format = "json";
        throw new \yii\web\NotAcceptableHttpException("Jasa service masih kosong.");
    }
    public function actionTunda($id)
    {
        $model = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        $model->perintah_kerja_status_id = \app\models\PerintahKerjaStatus::TUNDA;
        $model->waktu_pause = date("Y-m-d H:i:s");
        $model->save();
        $user = \app\models\User::find()->where(array("id" => $model->karyawan_id))->one();
        $user->is_on_duty = 0;
        $user->save();
        return \yii\helpers\Json::encode($model);
    }
    public function actionResume($id)
    {
        $model = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        $model->perintah_kerja_status_id = \app\models\PerintahKerjaStatus::DIKERJAKAN;
        $model->waktu_resume = date("Y-m-d H:i:s");
        $model->save();
        $user = \app\models\User::find()->where(array("id" => $model->karyawan_id))->one();
        $user->is_on_duty = 1;
        $user->save();
        return \yii\helpers\Json::encode($model);
    }
    public function actionSelesai($id)
    {
        $model = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        $model->perintah_kerja_status_id = \app\models\PerintahKerjaStatus::SELESAI;
        $model->waktu_selesai = date("Y-m-d H:i:s");
        $model->save();
        $user = \app\models\User::find()->where(array("id" => $model->karyawan_id))->one();
        $user->is_on_duty = 0;
        $user->save();
        return \yii\helpers\Json::encode($model);
    }
    public function actionPrePembayaran($id)
    {
        $model = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        $output = array("perintah_kerja" => $model, "nota_jasa" => null, "nota_suku_cadang" => null);
        $notaJasa = \app\models\NotaJasa::find()->where(array("perintah_kerja_id" => $id))->one();
        if ($notaJasa == null) {
            $notaJasa = new \app\models\NotaJasa();
            $notaJasa->jaringan_id = \app\models\Jaringan::getCurrentID();
            $notaJasa->generateNomorNota();
            $notaJasa->perintah_kerja_id = $id;
            $notaJasa->karyawan_id = $model->karyawan_id;
            $notaJasa->tanggal_njb = date("Y-m-d");
            $notaJasa->tanggal_jt = date("Y-m-d");
            $notaJasa->catatan = $model->catatan;
            $notaJasa->status_njb_id = \app\models\StatusNjb::ENTRY;
            $notaJasa->total = 0;
            $notaJasa->status_pembayaran_id = \app\models\StatusPembayaran::OPEN;
            $notaJasa->save();
        }
        $output["nota_jasa"] = $notaJasa;
        $notaSukuCadang = \app\models\PengeluaranPart::find()->where(array("no_referensi" => $id))->one();
        if ($notaSukuCadang == null) {
            $notaSukuCadang = new \app\models\PengeluaranPart();
            $notaSukuCadang->jaringan_id = \app\models\Jaringan::getCurrentID();
            $notaSukuCadang->generateNomorNota();
            $notaSukuCadang->pengeluaran_part_tipe_id = \app\models\PengeluaranPartTipe::WORKSHOP;
            $notaSukuCadang->no_referensi = $id;
            $notaSukuCadang->sales_id = $model->karyawan_id;
            $notaSukuCadang->tanggal_pengeluaran = date("Y-m-d");
            $notaSukuCadang->tanggal_jatuh_tempo = date("Y-m-d");
            $notaSukuCadang->konsumen_id = $model->konsumen_id;
            $notaSukuCadang->konsumen_nama = $model->konsumen->nama_pengguna;
            $notaSukuCadang->konsumen_alamat = $model->konsumen->alamat;
            $notaSukuCadang->konsumen_kota = $model->konsumen->wilayahKabupaten->nama;
            $notaSukuCadang->catatan = $model->catatan;
            $notaSukuCadang->status_nsc_id = \app\models\StatusNsc::ENTRY;
            $notaSukuCadang->status_pembayaran_id = \app\models\StatusPembayaran::OPEN;
            $notaSukuCadang->save();
        }
        $output["nota_suku_cadang"] = $notaSukuCadang;
        return \yii\helpers\Json::encode($output);
    }
    public function actionBayar($id)
    {
        $model = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        $model->perintah_kerja_status_id = \app\models\PerintahKerjaStatus::NOTA;
        $pengeluaran = \app\models\PengeluaranPart::find()->where(array("no_referensi" => $model->id))->one();
        $pengeluaran->status_pembayaran_id = \app\models\StatusPembayaran::CLOSE;
        $pengeluaran->save();
        foreach ($pengeluaran->pengeluaranPartDetails as $detail) {
            $detail->delete();
        }
        foreach ($model->perintahKerjaSukuCadangs as $detailSC) {
            $scj = $detailSC->sukuCadang->getSukuCadangJaringan();
            $hpp = 0;
            if ($scj != null) {
                $hpp = $scj->hpp;
            }
            $nsc = new \app\models\PengeluaranPartDetail();
            $nsc->jaringan_id = \app\models\Jaringan::getCurrentID();
            $nsc->pengeluaran_part_id = $pengeluaran->id;
            $nsc->suku_cadang_id = $detailSC->suku_cadang_id;
            $nsc->rak_id = $detailSC->rak_id;
            $nsc->harga_jual = $detailSC->harga;
            $nsc->hpp = $hpp;
            $nsc->quantity = $detailSC->quantity;
            $nsc->diskon_p = $detailSC->diskon_p;
            $nsc->diskon_r = $detailSC->diskon_r;
            $nsc->total = $detailSC->total;
            $nsc->beban_pembayaran_id = $detailSC->beban_pembayaran_id;
            $nsc->save();
        }
        $notaJasa = \app\models\NotaJasa::find()->where(array("perintah_kerja_id" => $model->id))->one();
        $notaJasa->status_pembayaran_id = \app\models\StatusPembayaran::CLOSE;
        $notaJasa->save();
        foreach ($notaJasa->notaJasaDetails as $detail) {
            $detail->delete();
        }
        foreach ($model->perintahKerjaJasas as $detailJ) {
            $njb = new \app\models\NotaJasaDetail();
            $njb->jaringan_id = \app\models\Jaringan::getCurrentID();
            $njb->nota_jasa_id = $notaJasa->id;
            $njb->jasa_id = $detailJ->jasa_id;
            $njb->nama_jasa = $detailJ->jasa->nama;
            $njb->harga = $detailJ->harga;
            $njb->diskon_p = $detailJ->diskon_p;
            $njb->diskon_r = $detailJ->diskon_r;
            $njb->total = $detailJ->total;
            $njb->beban_pembayaran_id = $detailJ->beban_pembayaran_id;
            $njb->save();
        }
        $model->save();
        $model->tunai_nominal = $_POST["tunai"];
        $model->debit_nominal = $_POST["debit"];
        $model->debit_terminal = $_POST["terminal"];
        $model->debit_bank = $_POST["bank"];
        $model->debit_no_kartu = $_POST["no_kartu"];
        $model->debit_pemilik = $_POST["pemilik"];
        $model->debit_approval_code = $_POST["approval_code"];
        $model->perintah_kerja_status_id = \app\models\PerintahKerjaStatus::NOTA;
        $model->save();
        $nsc = \app\models\PengeluaranPart::find()->where(array("no_referensi" => $model->id))->one();
        if ($nsc != null) {
            $nsc->status_nsc_id = \app\models\StatusNsc::CLOSE;
            $nsc->save();
        }
        $njb = \app\models\NotaJasa::find()->where(array("perintah_kerja_id" => $model->id))->one();
        if ($njb != null) {
            $njb->status_njb_id = \app\models\StatusNjb::CLOSE;
            $njb->save();
        }
        return \app\components\AjaxResponse::send($model, "Pembayaran berhasil dilakukan");
    }
    public function actionCetakPkb($id)
    {
        \Yii::$app->response->format = "pdf";
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 20, "beforeRender" => function ($mpdf, $data) {
        }, "header" => "<h2 style='text-align: center'>FORM SERVICE KONSUMEN</h2>"));
        return $this->renderPartial("cetak-pkb", array("model" => \app\models\PerintahKerja::find()->where(array("id" => $id))->one()));
    }
    public function actionCetakNota($id)
    {
        \Yii::$app->response->format = "pdf";
        $this->prosesPascaPenerimaan($id);
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 20, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("NOTA PEMBAYARAN")));
        return $this->renderPartial("cetak-nota", array("model" => \app\models\PerintahKerja::find()->where(array("id" => $id))->one()));
    }
    public function actionUserAvailable()
    {
        $output = array();
        foreach (\app\models\User::getNotBusyUsers() as $user) {
            $output[] = array("id" => $user->id, "text" => $user->kodeNama);
        }
        return \yii\helpers\Json::encode($output);
    }
    private function getHeaderNota($label)
    {
        $jaringan = \app\models\Jaringan::find()->where(array("id" => \app\models\Jaringan::getCurrentID()))->one();
        return "<table style='width: 100%'><tr><td>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</td><td>" . "<h2 style='text-align:right'>" . $label . "</h2>" . "</td></tr></table>";
    }
    public function actionCetakNotaJasa($id)
    {
        \Yii::$app->response->format = "pdf";
        $this->prosesPascaPenerimaan($id);
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 20, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("NOTA PEMBAYARAN")));
        return $this->renderPartial("cetak-nota-jasa", array("model" => \app\models\PerintahKerja::find()->where(array("id" => $id))->one()));
    }
    public function actionCetakNotaSukucadang($id)
    {
        \Yii::$app->response->format = "pdf";
        $this->prosesPascaPenerimaan($id);
        \Yii::$container->set(\Yii::$app->response->formatters["pdf"]["class"], array("format" => array(356, 216), "marginTop" => 20, "beforeRender" => function ($mpdf, $data) {
        }, "header" => $this->getHeaderNota("NOTA PEMBAYARAN")));
        return $this->renderPartial("cetak-nota-sukucadang", array("model" => \app\models\PerintahKerja::find()->where(array("id" => $id))->one()));
    }
    public function prosesPascaPenerimaan($id)
    {
        $model = \app\models\PerintahKerja::find()->where(array("id" => $id))->one();
        $model->perintah_kerja_status_id = \app\models\PerintahKerjaStatus::NOTA;
        $model->nomor_cetak += 1;
        $model->save();
        $nsc = \app\models\PengeluaranPart::find()->where(array("no_referensi" => $model->id))->one();
        if ($nsc != null) {
            $nsc->status_nsc_id = \app\models\StatusNsc::CLOSE;
            $nsc->save();
        }
        $njb = \app\models\NotaJasa::find()->where(array("perintah_kerja_id" => $model->id))->one();
        if ($njb != null) {
            $njb->status_njb_id = \app\models\StatusNjb::CLOSE;
            $njb->save();
        }
    }
}

?>