<?php

namespace app\controllers;

class ImportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionUpload()
    {
        ini_set("memory_limit", "4000M");
        set_time_limit(0);
        $model = new \app\models\UploadForm();
        $model2 = new \app\models\ExcelProcessor();
        $uploadForm = \Yii::$app->session->get("excel_upload");
        if ($uploadForm != null) {
            $model2->excelFilePath = $uploadForm->fileName;
            $model2->sheetList = $uploadForm->sheets;
        }
        if (\Yii::$app->request->isPost) {
            $model->imageFile = \yii\web\UploadedFile::getInstance($model, "imageFile");
            if ($model->upload()) {
                $model2->sheetList = $uploadForm->sheets;
                \Yii::$app->session->set("excel_upload", $model);
                return $this->redirect(array("upload"));
            }
        }
        return $this->render("upload", array("model" => $model, "model2" => $model2));
    }
    public function actionDeleteExcel()
    {
        \Yii::$app->session->set("excel_upload", null);
        return $this->redirect(array("upload"));
    }
    public function actionProcess()
    {
        ini_set("memory_limit", "4000M");
        set_time_limit(0);
        $ep = $_POST["ExcelProcessor"];
        $table = $ep["table"];
        $excelIndex = $ep["excel"];
        $uploadForm = \Yii::$app->session->get("excel_upload");
        \Yii::$app->session->set("alert", "Data berhasil diproses");
        if ($table == "supplier") {
            $this->processSupplier($excelIndex);
        } else {
            if ($table == "konsumen") {
                $this->processKonsumen($excelIndex);
            } else {
                if ($table == "sukuCadang") {
                    $this->processSukuCadang($excelIndex);
                } else {
                    if ($table == "jasa") {
                        $this->processJasa($excelIndex);
                    } else {
                        if ($table == "karyawan") {
                            $this->processKaryawan($excelIndex);
                        } else {
                            if ($table == "penerimaan") {
                                $this->processPenerimaan($excelIndex);
                            } else {
                                if ($table == "penerimaanDetail") {
                                    $this->processPenerimaanDetail($excelIndex);
                                } else {
                                    if ($table == "pengeluaran") {
                                        $this->processPengeluaran($excelIndex);
                                    } else {
                                        if ($table == "pengeluaranDetail") {
                                            $this->processPengeluaranDetail($excelIndex);
                                        } else {
                                            if ($table == "stockOpname") {
                                                $this->processStockOpname($excelIndex);
                                            } else {
                                                if ($table == "detailStockOpname") {
                                                    $this->processDetailStockOpname($excelIndex);
                                                } else {
                                                    if ($table == "absensi") {
                                                        $this->processAbsensi($excelIndex);
                                                    } else {
                                                        if ($table == "perintahKerja") {
                                                            $this->processPerintahKerja($excelIndex);
                                                        } else {
                                                            if ($table == "perintahKerjaDetailJasa") {
                                                                $this->processPerintahKerjaDetailJasa($excelIndex);
                                                            } else {
                                                                if ($table == "perintahKerjaDetailPart") {
                                                                    $this->processPerintahKerjaDetailPart($excelIndex);
                                                                } else {
                                                                    if ($table == "notaJasa") {
                                                                        $this->processNotaJasa($excelIndex);
                                                                    } else {
                                                                        if ($table == "notaJasaDetail") {
                                                                            $this->processNotaJasaDetail($excelIndex);
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this->redirect(array("upload"));
    }
    private function addToLog($message)
    {
        $log = \Yii::$app->session->get("log_error", array());
        $log[] = $message;
        \Yii::$app->session->set("log_error", $log);
    }
    private function safeDelete($tableName)
    {
        $sql = "SET foreign_key_checks = 0; DELETE FROM " . $tableName . " WHERE jaringan_id = '" . \app\models\Jaringan::getCurrentID() . "'";
        \app\components\NodeLogger::sendLog($sql);
        \Yii::$app->db->createCommand($sql)->execute();
    }
    private function formatDate($date)
    {
        $arr = explode("-", $date);
        if (count($arr) == 3) {
            $tahun = $arr[2];
            if ($tahun <= date("y")) {
                $tahun = "20" . $tahun;
            } else {
                $tahun = "19" . $tahun;
            }
            return $tahun . "-" . $arr[0] . "-" . $arr[1];
        }
        $arr = explode("/", $date);
        $tahun = $arr[2];
        if (strlen($tahun) == 2) {
            if ($tahun <= date("y")) {
                $tahun = "20" . $tahun;
            } else {
                $tahun = "19" . $tahun;
            }
        }
        return $tahun . "-" . $arr[1] . "-" . $arr[0];
    }
    private function formatTime($date, $time)
    {
        $arr = explode(" ", $time);
        if (count($arr) == 2) {
            return $date . " " . str_replace(".", ":", $arr[1]);
        }
        return null;
    }
    private function getSheetData($index)
    {
        $uploadForm = \Yii::$app->session->get("excel_upload");
        $sheetPath = $uploadForm->sheetFiles[$index];
        $csvData = file_get_contents($sheetPath);
        $lines = explode(PHP_EOL, $csvData);
        $array = array();
        $id = 0;
        foreach ($lines as $line) {
            if (0 < $id) {
                $array[] = str_getcsv($line, ";");
            }
            $id++;
        }
        return $array;
    }
    private function processSupplier($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        $this->safeDelete("supplier");
        $x = new \app\models\Supplier();
        $x->jaringan_id = \app\models\Jaringan::getCurrentID();
        $x->kode = "NOT_FOUND";
        $x->nama = "NOT_FOUND";
        $x->alamat = "NOT_FOUND";
        $x->save();
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $x = new \app\models\Supplier();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            list($x->kode, $x->nama, $x->alamat) = $item;
            $x->wilayah_propinsi_id = NULL;
            $x->wilayah_kabupaten_id = NULL;
            $x->wilayah_kecamatan_id = NULL;
            $x->wilayah_desa_id = NULL;
            list(, , , , , , $x->kodepos, $x->no_telp) = $item;
            $x->email = NULL;
            list(, , , , , , , , , $x->nama_pic, $x->no_telp_pic) = $item;
            $x->status = $item[11] == "TRUE" ? 1 : 0;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processKonsumen($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("konsumen");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $x = new \app\models\Konsumen();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->kode = $item[0];
            $x->jenis_identitas = "KTP";
            list($x->no_identitas, $x->nama_identitas, $x->nama_pengguna, $x->alamat) = $item;
            $x->wilayah_propinsi_id = NULL;
            $x->wilayah_kabupaten_id = NULL;
            $x->wilayah_kecamatan_id = NULL;
            $x->wilayah_desa_id = NULL;
            $x->kodepos = strlen($item[7]) <= 6 ? $item[7] : substr($item[7], 0, 6);
            list(, , , , , , , , $x->no_telepon, , , , , , $x->email) = $item;
            $x->no_whatsapp = NULL;
            $x->facebook = NULL;
            $x->instagram = NULL;
            $x->twitter = NULL;
            $x->tempat_lahir = NULL;
            $x->jenis_kelamin = $item[11] == "Laki-Laki" ? "L" : "P";
            $x->agama = $item[10];
            $x->tanggal_lahir = $this->formatDate($item[9]);
            $x->pendidikan = NULL;
            $x->pekerjaan = $item[12];
            $x->konsumen_group_id = \app\models\KonsumenGroup::findIdByKode($item[13]);
            list($x->nopol, , , , , , , , , , , , , , , $x->kode_motor, $x->no_mesin, $x->no_rangka) = $item;
            $x->tahun_rakit = intval($item[18]);
            $x->tanggal_beli = $this->formatDate($item[19]);
            list(, , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , $x->nama_dealer_beli, $x->kota_dealer_beli) = $item;
            $x->service_terakhir = $this->formatDate($item[20]);
            $x->kilometer_terakhir = intval($item[22]);
            $x->sms = NULL;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processSukuCadang($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $sql = "SET foreign_key_checks = 0; TRUNCATE suku_cadang;";
        \app\components\NodeLogger::sendLog($sql);
        \Yii::$app->db->createCommand($sql)->execute();
        $this->safeDelete("suku_cadang_jaringan");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $sc = new \app\models\SukuCadang();
            $sc->kode = $item[0];
            $sc->kode_plasa = NULL;
            list(, $sc->nama, $sc->nama_sinonim) = $item;
            $sc->suku_cadang_group_id = \app\models\SukuCadangGroup::findIdByKode($item[3]);
            $sc->suku_cadang_kategori_id = \app\models\SukuCadangKategori::findIdByKode($item[5]);
            $sc->merek_id = 1;
            $sc->fs = "S";
            $sc->import = "LOKAL";
            $sc->rank = 0;
            $sc->lifetime = "O";
            $sc->fungsi = "O";
            $sc->het = intval($item[6]);
            $sc->kode_promosi = NULL;
            $sc->dimensi_panjang = NULL;
            $sc->dimensi_lebar = NULL;
            $sc->dimensi_tinggi = NULL;
            $sc->dimensi_berat = NULL;
            $sc->status = 1;
            $sc->created_at = date("Y-m-d H:i:s");
            $sc->created_by = \app\models\User::getCurrentID();
            if ($sc->save()) {
                if (0 < $item[9]) {
                    $x = new \app\models\SukuCadangJaringan();
                    $x->jaringan_id = \app\models\Jaringan::getCurrentID();
                    $x->suku_cadang_id = $sc->id;
                    $x->gudang_id = null;
                    $x->rak_id = null;
                    $x->harga_beli = intval($item[7]);
                    $x->quantity = intval($item[9]);
                    $x->hpp = intval($item[8]);
                    $x->quantity_booking = intval($item[10]);
                    $x->quantity_max = intval($item[15]);
                    $x->quantity_min = intval($item[14]);
                    $x->kode_promosi = NULL;
                    $x->opname_terakhir = $this->formatDate($item[12]);
                    $x->status = 1;
                    $x->created_at = date("Y-m-d H:i:s");
                    $x->created_by = \app\models\User::getCurrentID();
                    if (!$x->save()) {
                        $adaError = true;
                        $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
                    }
                }
            } else {
                $adaError = true;
                $this->addToLog("Error SC, Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($sc->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processJasa($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("jasa");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            if ($item[2] == "LL") {
                $item[2] = "LR";
            }
            $x = new \app\models\Jasa();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            list($x->kode, $x->nama) = $item;
            $x->jasa_group_id = \app\models\JasaGroup::findIdByKode($item[2]);
            list(, , , $x->frt, $x->harga) = $item;
            $x->pph = 0;
            $x->operasional = 0;
            $x->pilih = 1;
            $x->status = $item[9] == "TRUE" ? 1 : 0;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                \app\components\NodeLogger::sendLog("Jasa Group ID : " . $item[2] . ", " . $x->jasa_group_id);
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processKaryawan($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $sql = "SET foreign_key_checks = 0; DELETE FROM user WHERE jaringan_id = '" . \app\models\Jaringan::getCurrentID() . "' AND username != 'admin'";
        \Yii::$app->db->createCommand($sql)->execute();
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $x = new \app\models\User();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->username = \Yii::$app->security->generateRandomString(10);
            $x->password = md5($x->username);
            list($x->kode, $x->name) = $item;
            $x->role_id = \app\models\Role::MEKANIK;
            list(, , $x->alamat, , , , , $x->no_telpon) = $item;
            $x->email = NULL;
            $x->tempat_lahir = NULL;
            $x->tanggal_lahir = $this->formatDate($item[4]);
            $x->agama = $item[5];
            $x->jenis_kelamin = "L";
            $x->pendidikan = $item[60];
            $x->tanggal_masuk = NULL;
            $x->tanggal_keluar = NULL;
            $x->is_on_duty = 0;
            $x->pit_id = NULL;
            $x->last_login = NULL;
            $x->last_logout = NULL;
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processPenerimaan($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("penerimaan_part");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            if ($item[4] == "REGULAR") {
                $item[4] = "REGULER";
            } else {
                if ($item[4] == "") {
                    $item[4] = "CASH";
                }
            }
            $x = new \app\models\PenerimaanPart();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            list($x->no_spg, $x->no_faktur) = $item;
            $x->supplier_id = \app\models\Supplier::findIdByKode($item[5]);
            $x->purchase_order_id = NULL;
            $x->tanggal_faktur = $this->formatDate($item[3]);
            $x->tanggal_penerimaan = $this->formatDate($item[2]);
            $x->penerimaan_part_tipe_id = \app\models\PenerimaanPartTipe::PEMBELIAN;
            $x->pembayaran_id = \app\models\Pembayaran::findIdByKode($item[4]);
            $x->tanggal_jatuh_tempo = $this->formatDate($item[7]);
            $x->status_spg_id = \app\models\StatusSpg::findIdByKode($item[9]);
            $x->total = intval($item[8]);
            $x->no_retur = $item[11];
            $x->tanggal_retur = NULL;
            $x->keterangan_retur = $item[12];
            $x->status_hutang_id = \app\models\StatusHutang::findIdByKode($item[18]);
            $x->approved_by = NULL;
            list(, , , , , , , , , , , , , , , , $x->bukti_bayar, $x->bank_bayar) = $item;
            $x->tanggal_bayar = $this->formatDate($item[15]);
            $x->status = 1;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if ($x->pembayaran_id == null) {
                $x->pembayaran_id = 1;
            }
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processPenerimaanDetail($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("penerimaan_part_detail");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $suku_cadang_id = \app\models\SukuCadang::findIdByKode($item[2]);
            if ($suku_cadang_id == null) {
                $this->addToLog("Error Baris:" . ($id + 1) . " => Kode Part Tidak Ditemukan " . $item[0]);
                $id++;
                continue;
            }
            $x = new \app\models\PenerimaanPartDetail();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->penerimaan_part_id = \app\models\PenerimaanPart::findIdByKode($item[0]);
            $x->suku_cadang_id = $suku_cadang_id;
            $x->harga_beli = $item[3];
            $x->quantity_order = intval($item[4]);
            $x->quantity_supp = intval($item[5]);
            $x->diskon_p = $item[6];
            $x->diskon_r = intval($item[7]);
            $x->rak_id = NULL;
            $x->total_harga = intval($x->harga_beli * $x->quantity_supp - ($x->diskon_p != null ? $x->diskon_p / 100 * $x->harga_beli * $x->quantity_supp : $x->diskon_r));
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processPengeluaran($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("pengeluaran_part");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $x = new \app\models\PengeluaranPart();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->no_nsc = $item[0];
            $x->pengeluaran_part_tipe_id = \app\models\PengeluaranPartTipe::findIdByKode($item[1]);
            if ($x->pengeluaran_part_tipe_id == \app\models\PengeluaranPartTipe::WORKSHOP) {
                $x->no_referensi = \app\models\PerintahKerja::findIdByKode($item[3]);
            }
            if ($x->pengeluaran_part_tipe_id == null) {
                $x->pengeluaran_part_tipe_id = \app\models\PengeluaranPartTipe::DIRECT_SALES;
            }
            $x->sales_id = NULL;
            $x->tanggal_pengeluaran = $this->formatDate($item[2]);
            $x->tanggal_jatuh_tempo = $this->formatDate($item[5]);
            $x->konsumen_id = NULL;
            list(, , , , , , , , $x->konsumen_nama, $x->konsumen_alamat, $x->konsumen_kota) = $item;
            $x->nomor_cetak = intval($item[17]);
            $x->catatan = $item[19];
            $x->status_nsc_id = 1;
            $x->keterangan_retur = $item[21];
            $x->tanggal_retur = $this->formatDate($item[13]);
            $x->approved_by = NULL;
            $x->nomor_retur = $item[20];
            $x->status_pembayaran_id = 2;
            $x->total = intval($item[11]);
            $x->bank_bayar_reguler = NULL;
            $x->bukti_bayar_reguler = NULL;
            $x->tanggal_bayar_reguler = NULL;
            $x->konsumen_penerima_id = NULL;
            $x->status = 1;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            if ($id % 1000 == 0) {
                \app\components\NodeLogger::sendLog("Current ID " . $id);
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processPengeluaranDetail($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("pengeluaran_part_detail");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $suku_cadang_id = \app\models\SukuCadang::findIdByKode($item[1]);
            if ($suku_cadang_id == null) {
                $this->addToLog("Error Baris:" . ($id + 1) . " => Kode Part Tidak Ditemukan " . $item[0]);
                continue;
            }
            $x = new \app\models\PengeluaranPartDetail();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->pengeluaran_part_id = \app\models\PengeluaranPart::findIdByKode($item[0]);
            $x->suku_cadang_id = $suku_cadang_id;
            $x->rak_id = NULL;
            $x->het = intval($item[3]);
            $x->hpp = intval($item[2]);
            $x->quantity = intval($item[4]);
            $x->diskon_p = floatval($item[6]);
            $x->diskon_r = intval($item[5]);
            $x->total = intval($x->het * $x->quantity - ($x->diskon_p != null ? $x->diskon_p / 100 * $x->het * $x->quantity : $x->diskon_r));
            $x->beban_pembayaran_id = 1;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            if ($id % 1000 == 0) {
                \app\components\NodeLogger::sendLog("Current ID " . $id);
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processStockOpname($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("stock_opname");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $x = new \app\models\StockOpname();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->no_opname = $item[0];
            $x->tanggal_opname = $this->formatDate($item[1]);
            $x->tanggal_closing = $this->formatDate($item[1]);
            $x->petugas_id = $item[5] != "" ? \app\models\User::findIdByNama(substr($item[5], 0, 10)) : \app\models\User::getCurrentID();
            $x->status_opname_id = $item[3] == "OPEN" ? 1 : 2;
            $x->status = 1;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processDetailStockOpname($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("stock_opname_detail");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $suku_cadang_id = \app\models\SukuCadang::findIdByKode($item[1]);
            if ($suku_cadang_id == null) {
                $this->addToLog("Error Baris:" . ($id + 1) . " => Kode Part Tidak Ditemukan " . $item[0]);
                $id++;
                continue;
            }
            $x = new \app\models\StockOpnameDetail();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->stock_opname_id = \app\models\StockOpname::findIdByKode($item[0]);
            $x->jumlah_recount = 0;
            $x->rak_id = NULL;
            $x->suku_cadang_id = $suku_cadang_id;
            list(, , $x->quantity_sy, $x->quantity_oh, $x->keterangan) = $item;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            if ($id % 1000 == 0) {
                \app\components\NodeLogger::sendLog("Current ID " . $id);
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processAbsensi($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("absensi");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $x = new \app\models\Absensi();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->karyawan_id = \app\models\User::findIdByKode($item[1]);
            $x->absensi_status_id = 1;
            $x->keterangan = NULL;
            $x->jam_masuk = $this->formatDate($item[2]);
            $x->jam_pulang = $this->formatDate($item[3]);
            $x->status_kerja = 0;
            $x->status = 1;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processPerintahKerja($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("perintah_kerja");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $x = new \app\models\PerintahKerja();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->perintah_kerja_tipe_id = 1;
            $x->nomor = $item[0];
            $x->tanggal_ass = $this->formatDate($item[1]);
            $x->no_antrian = $item[3];
            $x->konsumen_id = NULL;
            $x->karyawan_id = NULL;
            list(, , , , , , $x->km, , $x->bbm, $x->kondisi_awal, $x->keluhan, , $x->analisa) = $item;
            $x->konfirmasi = $item[11] == "TRUE" ? 1 : 0;
            $x->dari_sms = 0;
            $x->catatan = NULL;
            $x->waktu_daftar = $this->formatTime($x->tanggal_ass, $item[14]);
            $x->waktu_kerja = $this->formatTime($x->tanggal_ass, $item[15]);
            $x->waktu_selesai = $this->formatTime($x->tanggal_ass, $item[16]);
            $x->waktu_pause = $this->formatTime($x->tanggal_ass, $item[17]);
            $x->waktu_resume = $this->formatTime($x->tanggal_ass, $item[18]);
            $x->durasi_service = $item[19] * 60;
            $x->jumlah_tunggu_menit = $item[20];
            $x->perintah_kerja_status_id = 1;
            $x->status_njb_id = 1;
            $x->status_nsc_id = 1;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if ($id % 1000 == 0) {
                \app\components\NodeLogger::sendLog("Current ID " . $id);
            }
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processPerintahKerjaDetailJasa($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("perintah_kerja_jasa");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $jasa_id = \app\models\Jasa::findIdByKode($item[1]);
            if ($jasa_id == null) {
                $this->addToLog("Error Baris:" . ($id + 1) . " => Kode Jasa Tidak Ditemukan " . $item[1]);
                $id++;
                continue;
            }
            $pk_id = \app\models\PerintahKerja::findIdByKode($item[0]);
            if ($pk_id == null) {
                $this->addToLog("Error Baris:" . ($id + 1) . " => PKB Tidak Ditemukan " . $item[0]);
                $id++;
                continue;
            }
            $x = new \app\models\PerintahKerjaJasa();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->perintah_kerja_id = $pk_id;
            $x->jasa_id = $jasa_id;
            $x->harga = intval($item[2]);
            $x->diskon_p = intval($item[3]);
            $x->diskon_r = intval($item[4]);
            $x->total = intval($x->harga - ($x->diskon_p != null ? $x->diskon_p / 100 * $x->harga : $x->diskon_r));
            $x->dpph = 0;
            $x->dpp = 0;
            $x->pph = 0;
            $x->ppn = 0;
            $x->operasional = 0;
            $x->beban_pembayaran_id = 1;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            if ($id % 1000 == 0) {
                \app\components\NodeLogger::sendLog("Current ID " . $id);
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processPerintahKerjaDetailPart($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("perintah_kerja_suku_cadang");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $sc_id = \app\models\SukuCadang::findIdByKode($item[1]);
            if ($sc_id == null) {
                $this->addToLog("Error Baris:" . ($id + 1) . " => Kode Part Tidak Ditemukan " . $item[1]);
                $id++;
                continue;
            }
            $pk_id = \app\models\PerintahKerja::findIdByKode($item[0]);
            if ($pk_id == null) {
                $this->addToLog("Error Baris:" . ($id + 1) . " => PKB Tidak Ditemukan " . $item[0]);
                $id++;
                continue;
            }
            $x = new \app\models\PerintahKerjaSukuCadang();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->perintah_kerja_id = $pk_id;
            $x->suku_cadang_id = $sc_id;
            $x->rak_id = NULL;
            $x->hpp = intval($item[2]);
            $x->harga = intval($item[2]);
            $x->diskon_p = intval($item[6]);
            $x->diskon_r = intval($item[5]);
            $x->total = intval($x->hpp - ($x->diskon_p != null ? $x->diskon_p / 100 * $x->hpp : $x->diskon_r));
            $x->beban_pembayaran_id = 1;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            if ($id % 1000 == 0) {
                \app\components\NodeLogger::sendLog("Current ID " . $id);
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processNotaJasa($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("nota_jasa");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $x = new \app\models\NotaJasa();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->nomor = $item[0];
            $x->perintah_kerja_id = \app\models\PerintahKerja::findIdByKode($item[2]);
            $x->karyawan_id = \app\models\User::getCurrentID();
            $x->tanggal_njb = $this->formatDate($item[1]);
            $x->tanggal_jt = $this->formatDate($item[4]);
            $x->catatan = NULL;
            $x->nomor_cetak = $item[14];
            $x->status_njb_id = \app\models\StatusNjb::CLOSE;
            list(, , , , , , , $x->total, , , , , , , , , $x->no_batal) = $item;
            $x->tanggal_batal = $this->formatDate($item[19]);
            $x->approved_by = NULL;
            $x->status_pembayaran_id = \app\models\StatusPembayaran::CLOSE;
            $x->tanggal_bayar = NULL;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            if ($id % 1000 == 0) {
                \app\components\NodeLogger::sendLog("Current ID " . $id);
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
    private function processNotaJasaDetail($index)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $data = $this->getSheetData($index);
        \app\components\NodeLogger::sendLog($data[1]);
        $this->safeDelete("nota_jasa_detail");
        $id = 1;
        $adaError = false;
        foreach ($data as $item) {
            if ($item[1] == "") {
                continue;
            }
            $x = new \app\models\NotaJasaDetail();
            $x->jaringan_id = \app\models\Jaringan::getCurrentID();
            $x->nota_jasa_id = \app\models\NotaJasa::findIdByKode($item[0]);
            $x->jasa_id = \app\models\Jasa::findIdByKode($item[1]);
            $x->nama_jasa = $x->jasa->nama;
            list(, , $x->harga, $x->diskon_r, $x->diskon_p) = $item;
            $x->total = intval($x->harga - ($x->diskon_p != null ? $x->diskon_p / 100 * $x->harga : $x->diskon_r));
            $x->dpph = 0;
            $x->dpp = 0;
            $x->pph = 0;
            $x->ppn = 0;
            $x->operasional = 0;
            $x->beban_pembayaran_id = 1;
            $x->created_at = date("Y-m-d H:i:s");
            $x->created_by = \app\models\User::getCurrentID();
            if ($x->jasa_id == null) {
                $id++;
                continue;
            }
            if (!$x->save()) {
                $adaError = true;
                $this->addToLog("Error Baris:" . ($id + 1) . " => " . \app\components\Utility::processError($x->errors));
            }
            if ($id % 1000 == 0) {
                \app\components\NodeLogger::sendLog("Current ID " . $id);
            }
            $id++;
        }
        if ($adaError) {
            $transaction->rollBack();
            \Yii::$app->session->set("alert", "Data gagal diproses");
        } else {
            $transaction->commit();
        }
    }
}

?>