<?php

namespace app\controllers;

class ApiController extends \yii\rest\Controller
{
    public $enableCsrfValidation = false;
    public function beforeAction($action)
    {
        $_GET["_format"] = "json";
        return parent::beforeAction($action);
    }
    public function actionAuth($username, $password)
    {
        $user = \app\models\User::find()->where(array("username" => $username, "password" => md5($password)))->one();
        if ($user) {
            $user->generateToken();
            $user->save();
        }
        return $user;
    }
    public function actionSukuCadangInfo($token, $kode)
    {
        $user = \app\models\User::find()->where(array("token" => $token))->one();
        if ($user) {
            $sukuCadang = \app\models\SukuCadang::find()->where(array("kode" => trim($kode)))->one();
            if ($sukuCadang) {
                $quantity = 0;
                $sukuCadangJaringan = \app\models\SukuCadangJaringan::find()->where(array("suku_cadang_id" => $sukuCadang->id, "jaringan_id" => $user->jaringan_id))->one();
                if ($sukuCadangJaringan != null) {
                    $quantity = $sukuCadangJaringan->quantity;
                }
                $outputSC = array("kode" => $sukuCadang->kode, "nama" => $sukuCadang->nama, "nama_sinonim" => $sukuCadang->nama_sinonim, "quantity" => $quantity);
                return array("status" => "FOUND", "suku_cadang" => $outputSC);
            }
            return array("status" => "NOT_FOUND");
        }
    }
    public function actionSukuCadangUpdate($token, $kode, $jumlah)
    {
        $user = \app\models\User::find()->where(array("token" => $token))->one();
        if ($user) {
            $sukuCadang = \app\models\SukuCadang::find()->where(array("kode" => trim($kode)))->one();
            if ($sukuCadang) {
                $sukuCadangJaringan = \app\models\SukuCadangJaringan::find()->where(array("suku_cadang_id" => $sukuCadang->id, "jaringan_id" => $user->jaringan_id))->one();
                if ($sukuCadangJaringan == null) {
                    $sukuCadangJaringan = new \app\models\SukuCadangJaringan();
                }
                $sukuCadangJaringan->suku_cadang_id = $sukuCadang->id;
                $sukuCadangJaringan->quantity = $jumlah;
                $sukuCadangJaringan->jaringan_id = $user->jaringan_id;
                $sukuCadangJaringan->opname_terakhir = date("Y-m-d");
                if (!$sukuCadangJaringan->save()) {
                    \app\components\NodeLogger::sendLog($sukuCadangJaringan->errors);
                } else {
                    \app\components\NodeLogger::sendLog("Sukses");
                }
            } else {
                \app\components\NodeLogger::sendLog("Suku cadang tidak ditemukan");
            }
        } else {
            \app\components\NodeLogger::sendLog("Token " . $token . " Tidak ditemukan");
        }
    }
    public function actionSukuCadangCreate($token)
    {
        $json = \yii\helpers\Json::decode(file_get_contents("php://input"));
        $user = \app\models\User::find()->where(array("token" => $token))->one();
        if ($user) {
            $sukuCadang = \app\models\SukuCadang::find()->where(array("kode" => trim($json["kode"])))->one();
            if ($sukuCadang == null) {
                $sukuCadang = new \app\models\SukuCadang();
                $sukuCadang->kode = $json["kode"];
                $sukuCadang->nama = $json["nama"];
                $sukuCadang->nama_sinonim = $json["sinonim"];
                if ($sukuCadang->save()) {
                    $sukuCadangJaringan = new \app\models\SukuCadangJaringan();
                    $sukuCadangJaringan->suku_cadang_id = $sukuCadang->id;
                    $sukuCadangJaringan->quantity = $json["jumlah"];
                    $sukuCadangJaringan->jaringan_id = $user->jaringan_id;
                    $sukuCadangJaringan->opname_terakhir = date("Y-m-d");
                    if ($sukuCadangJaringan->save()) {
                        return array("status" => "OK");
                    }
                    \app\components\NodeLogger::sendLog($sukuCadangJaringan->errors);
                } else {
                    \app\components\NodeLogger::sendLog($sukuCadang->errors);
                }
            }
        }
        return array("status" => "ERROR");
    }
    public function actionStok()
    {
        $sukuCadangs = \app\models\SukuCadang::find()->where(array("id" => array(31356, 31355, 31354)))->limit(10)->all();
        $output = array();
        foreach ($sukuCadangs as $sukuCadang) {
            $stok = array();
            $stokTotal = 0;
            foreach ($sukuCadang->sukuCadangJaringans as $sukuCadangJaringan) {
                $stok[] = array("bengkel_id" => $sukuCadangJaringan->jaringan_id, "stok" => $sukuCadangJaringan->quantity);
                $stokTotal += $sukuCadangJaringan->quantity;
            }
            $output[] = array("id" => $sukuCadang->id, "kode" => $sukuCadang->kode, "nama" => $sukuCadang->nama, "nama_sinonim" => $sukuCadang->nama_sinonim, "stok_total" => $stokTotal, "group_id" => $sukuCadang->suku_cadang_group_id, "dimensi_panjang" => $sukuCadang->dimensi_panjang, "dimensi_lebar" => $sukuCadang->dimensi_lebar, "dimensi_tinggi" => $sukuCadang->dimensi_tinggi, "dimensi_berat" => $sukuCadang->dimensi_berat, "stok_data" => $stok);
        }
        \app\components\NodeLogger::sendLog($output);
        echo \yii\helpers\Json::encode($output);
    }
    public function actionBengkel()
    {
        $output = array();
        $jaringans = \app\models\Jaringan::find()->all();
        foreach ($jaringans as $jaringan) {
            $output[] = array("id" => $jaringan->id, "kode" => $jaringan->kode, "nama" => $jaringan->nama, "propinsi" => $jaringan->wilayahPropinsi->nama, "kabupaten" => $jaringan->wilayahKabupaten->nama, "kecamatan" => $jaringan->wilayahKecamatan->nama, "kelurahan" => $jaringan->wilayahDesa->nama, "alamat" => $jaringan->alamat, "kodepos" => $jaringan->kodepos, "no_telepon" => $jaringan->no_telepon);
        }
        \app\components\NodeLogger::sendLog($output);
        echo \yii\helpers\Json::encode($output);
    }
}

?>