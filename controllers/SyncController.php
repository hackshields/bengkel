<?php

namespace app\controllers;

class SyncController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render("index");
    }
    private function getJaringanId()
    {
        return \Yii::$app->session->get("jaringan_id");
    }
    private function getSyncTime()
    {
        $setting = \app\models\Setting::find()->where(array("key" => "SERVER_UPDATE_TIME"))->one();
        if ($setting == null) {
            $setting = new \app\models\Setting();
            $setting->key = "SERVER_UPDATE_TIME";
            $setting->value = "2017-06-01";
            $setting->save();
        }
        return $setting->value;
    }
    private function offForeignKey()
    {
        $db = \Yii::$app->db;
        $sql = "SET NAMES utf8;\n                SET time_zone = '+00:00';\n                SET foreign_key_checks = 0;\n                SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';";
        $db->createCommand($sql)->execute();
    }
    public function actionTest()
    {
        var_dump($this->getJaringanId());
    }
    public function actionValidateSerialNumber($serial)
    {
        $url = \Yii::$app->params["server_url"] . "/sync/validate-serial/?serial=" . $serial;
        $response = \Httpful\Request::get($url)->expectsJson()->send();
        if ($response->body->status == "OK") {
            \Yii::$app->session->set("jaringan_id", $response->body->jaringan_id->id);
            $db = \Yii::$app->db;
            $this->offForeignKey();
            foreach (\Yii::$app->db->getSchema()->tableNames as $tableName) {
                if (strncmp($tableName, "wilayah_", 8) === 0) {
                } else {
                    if (strncmp($tableName, "view_", 5) === 0) {
                    } else {
                        if ($tableName == "suku_cadang") {
                        } else {
                            $db->createCommand("truncate `" . $tableName . "`")->execute();
                        }
                    }
                }
            }
        }
        return \yii\helpers\Json::encode($response->body);
    }
    public function actionConst()
    {
        $url = \Yii::$app->params["server_url"] . "/sync/const";
        $response = \Httpful\Request::get($url)->expectsJson()->send();
        foreach ($response->body as $key => $value) {
            $this->updateConst($key, $value);
        }
    }
    private function updateConst($tableName, $dataArray, $isTruncate = true)
    {
        $db = \Yii::$app->db;
        $this->offForeignKey();
        if ($isTruncate) {
            $db->createCommand("truncate `" . $tableName . "`")->execute();
            foreach ($dataArray as $item) {
                $status = $db->createCommand()->insert($tableName, $item)->execute();
            }
        } else {
            $model = "\\app\\models\\base\\" . \yii\helpers\Inflector::camelize($tableName);
            foreach ($dataArray as $item) {
                $item = (array) $item;
                $currentRecord = $model::find()->where(array("id" => $item["id"]))->one();
                if ($currentRecord == null) {
                    $db->createCommand()->insert($tableName, $item)->execute();
                } else {
                    unset($item["id"]);
                    $db->createCommand()->update($tableName, $item, array("id" => $item["id"]))->execute();
                }
            }
        }
    }
    public function actionSukuCadang()
    {
        ini_set("memory_limit", "4000M");
        set_time_limit(3600);
        $url = \Yii::$app->params["server_url"] . "/sync/suku-cadang";
        $response = \Httpful\Request::get($url)->expectsJson()->send();
        foreach ($response->body as $key => $value) {
            $this->updateConst($key, $value);
        }
    }
    public function actionMaster()
    {
        ini_set("memory_limit", "4000M");
        set_time_limit(3600);
        $url = \Yii::$app->params["server_url"] . "/sync/master?jaringan_id=" . $this->getJaringanId() . "&time=" . $this->getSyncTime();
        $response = \Httpful\Request::get($url)->expectsJson()->send();
        $this->offForeignKey();
        foreach ($response->body as $key => $value) {
            $this->updateTransaction($key, $value);
        }
    }
    public function actionAccess()
    {
        $url = \Yii::$app->params["server_url"] . "/sync/access?jaringan_id=" . $this->getJaringanId();
        $response = \Httpful\Request::get($url)->expectsJson()->send();
        $this->offForeignKey();
        foreach ($response->body as $key => $value) {
            if ($key == "jaringan") {
                unset($value->client_last_sync);
                $this->updateConst($key, array($value));
            } else {
                if ($key == "user") {
                    $this->updateConst($key, $value);
                }
            }
        }
    }
    public function actionTransaction()
    {
        ini_set("memory_limit", "4000M");
        set_time_limit(3600);
        $interval = 5;
        $oldTime = strtotime($this->getSyncTime());
        $now = strtotime(date("Y-m-d H:i:s"));
        $time = $oldTime;
        while ($time < $now) {
            $endTime = $time + $interval * 24 * 3600 - 1;
            $url = \Yii::$app->params["server_url"] . "/sync/transaction?jaringan_id=" . $this->getJaringanId() . "&time=" . date("Y-m-d+H:i:s", $time) . "&end_time=" . date("Y-m-d+H:i:s", $endTime);
            $response = \Httpful\Request::get($url)->expectsJson()->send();
            \app\components\NodeLogger::sendLog(date("Y-m-d H:i:s", $time) . " s/d " . date("Y-m-d H:i:s", $endTime));
            $this->offForeignKey();
            foreach ($response->body as $key => $value) {
                if ($key == "name") {
                    \app\components\NodeLogger::sendLog($response->body);
                }
                $this->updateTransaction($key, $value);
            }
            $time += $interval * 24 * 3600;
            unset($response);
        }
    }
    public function actionGetTime()
    {
        ini_set("memory_limit", "4000M");
        set_time_limit(3600);
        $url = \Yii::$app->params["server_url"] . "/sync/time?jaringan_id=" . $this->getJaringanId() . "&time=" . $this->getSyncTime();
        $response = \Httpful\Request::get($url)->expectsJson()->send();
        $setting = \app\models\Setting::find()->where(array("key" => "SERVER_UPDATE_TIME"))->one();
        $setting->value = $response->body->time;
        $setting->save();
        \app\models\Setting::setSyncDone();
        \Yii::$app->cache->set("LAST_ONLINE", date("Y-m-d H:i:s"));
    }
    private function uploadTransaction($tableName)
    {
        $db = \Yii::$app->db;
        $model = "\\app\\models\\base\\" . \yii\helpers\Inflector::camelize($tableName);
        $data = $model::find()->where(array("is_need_update" => 1))->all();
        foreach ($data as $item) {
            $url = \Yii::$app->params["server_url"] . "/sync/upload?jaringan_id=" . $this->getJaringanId() . "&table_name=" . $tableName;
            $response = \Httpful\Request::post($url)->sendsJson()->body(\yii\helpers\Json::encode($item))->expectsJson()->send();
            $item->online_id = $response->body->ret_code;
            $item->is_need_update = 0;
            $item->save();
        }
    }
    private function updateTransaction($tableName, $dataArray)
    {
        \app\components\NodeLogger::sendLog("Client::updateTransaction " . $tableName);
        $db = \Yii::$app->db;
        $model = "\\app\\models\\base\\" . \yii\helpers\Inflector::camelize($tableName);
        $success = 0;
        \app\components\NodeLogger::sendLog($tableName . " Row Count : " . count($dataArray));
        foreach ($dataArray as $item) {
            $currentRecord = $model::find()->where(array("online_id" => $item->id))->one();
            $itemArray = (array) $item;
            $itemArray["online_id"] = $item->id;
            if ($currentRecord == null) {
                $status = $db->createCommand()->insert($tableName, $this->processLocalId($tableName, $itemArray))->execute();
            } else {
                $status = $db->createCommand()->update($tableName, $this->processLocalId($tableName, $itemArray), array("online_id" => $item->id))->execute();
            }
            if ($status != 0) {
                $success++;
            }
        }
        \app\components\NodeLogger::sendLog($tableName . " Success : " . $success . "/" . count($dataArray));
    }
    private function processLocalId($tableName, $data)
    {
        switch ($tableName) {
            case "gudang":
                break;
            case "jasa":
                break;
            case "konsumen_group":
                break;
            case "konsumen":
                $data = $this->processColumn($data, "konsumen_group_id", \app\models\base\KonsumenGroup::find());
                break;
            case "rak":
                $data = $this->processColumn($data, "gudang_id", \app\models\base\Gudang::find());
                break;
            case "supplier":
                break;
            case "absensi":
                break;
            case "hari_aktif":
                break;
            case "nota_jasa":
                $data = $this->processColumn($data, "perintah_kerja_id", \app\models\base\PerintahKerja::find());
                break;
            case "nota_jasa_detail":
                $data = $this->processColumn($data, "nota_jasa_id", \app\models\base\NotaJasa::find());
                $data = $this->processColumn($data, "jasa_id", \app\models\base\Jasa::find());
                break;
            case "penerimaan_part":
                $data = $this->processColumn($data, "supplier_id", \app\models\base\Supplier::find());
                $data = $this->processColumn($data, "purchase_order_id", \app\models\base\PurchaseOrder::find());
                break;
            case "penerimaan_part_detail":
                $data = $this->processColumn($data, "penerimaan_part_id", \app\models\base\PenerimaanPart::find());
                $data = $this->processColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "pengeluaran_part":
                $data = $this->processColumn($data, "no_referensi", \app\models\base\PerintahKerja::find());
                $data = $this->processColumn($data, "konsumen_id", \app\models\base\Konsumen::find());
                $data = $this->processColumn($data, "konsumen_penerima_id", \app\models\base\Konsumen::find());
                break;
            case "pengeluaran_part_detail":
                $data = $this->processColumn($data, "pengeluaran_part_id", \app\models\base\PengeluaranPart::find());
                $data = $this->processColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "perintah_kerja":
                $data = $this->processColumn($data, "konsumen_id", \app\models\base\Konsumen::find());
                break;
            case "perintah_kerja_jasa":
                $data = $this->processColumn($data, "perintah_kerja_id", \app\models\base\PerintahKerja::find());
                $data = $this->processColumn($data, "jasa_id", \app\models\base\Jasa::find());
                break;
            case "perintah_kerja_suku_cadang":
                $data = $this->processColumn($data, "perintah_kerja_id", \app\models\base\PerintahKerja::find());
                $data = $this->processColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "purchase_order":
                $data = $this->processColumn($data, "supplier_id", \app\models\base\Supplier::find());
                break;
            case "purchase_order_detail":
                break;
            case "stock_opname":
                break;
            case "stock_opname_detail":
                $data = $this->processColumn($data, "stock_opname_id", \app\models\base\StockOpname::find());
                $data = $this->processColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "stock_opname_recount":
                $data = $this->processColumn($data, "stock_opname_id", \app\models\base\StockOpname::find());
                $data = $this->processColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "suku_cadang_jaringan":
                $data = $this->processColumn($data, "gudang_id", \app\models\base\Gudang::find());
                $data = $this->processColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "suku_cadang_kosong":
                break;
        }
        return $data;
    }
    private function processColumn($data, $column, $query)
    {
        if (isset($data[$column]) && $data[$column] != null) {
            $model = $query->where(array("online_id" => $data[$column]))->one();
            $data[$column] = $model->id;
        }
        return $data;
    }
    public function actionAutomatic()
    {
        set_time_limit(0);
        $output = array("status" => "OK", "message" => "Sync OK", "must_logout" => false);
        $uTime = \app\models\Setting::getUpdateTime();
        $time = strtotime($uTime);
        if (\Yii::$app->user->isGuest) {
            return \yii\helpers\Json::encode(array());
        }
        try {
            $url = \Yii::$app->params["server_url"] . "/sync/latest?jaringan_id=" . \app\models\Jaringan::getCurrentID() . "&time=" . date("Y-m-d+H:i:s", $time);
            $response = \Httpful\Request::get($url)->expectsJson()->timeout(60)->send();
        } catch (\Httpful\Exception\ConnectionErrorException $exception) {
            $output["status"] = "ERROR";
            $output["message"] = "Tidak dapat terkoneksi dengan internet";
            return \yii\helpers\Json::encode($output);
        }
        \app\components\NodeLogger::sendLog("sync/latest");
        \app\components\NodeLogger::sendLog($response->body);
        foreach ($response->body->const as $tableName => $dataArray) {
            $this->updateConst($tableName, $dataArray, false);
        }
        foreach ($response->body->transaction as $tableName => $dataArray) {
            $this->updateTransaction($tableName, $dataArray);
        }
        $arrayOfData = array("gudang", "jasa", "konsumen_group", "konsumen", "rak", "supplier", "absensi", "hari_aktif", "perintah_kerja", "perintah_kerja_jasa", "perintah_kerja_suku_cadang", "purchase_order", "purchase_order_detail", "nota_jasa", "nota_jasa_detail", "penerimaan_part", "penerimaan_part_detail", "pengeluaran_part", "pengeluaran_part_detail", "stock_opname", "stock_opname_detail", "stock_opname_recount", "suku_cadang_jaringan", "suku_cadang_kosong");
        $serverTime = null;
        foreach ($arrayOfData as $tableName) {
            $url = \Yii::$app->params["server_url"] . "/sync/automatic?jaringan_id=" . \app\models\Jaringan::getCurrentID() . "&table_name=" . $tableName . "&time=" . date("Y-m-d+H:i:s", $time);
            try {
                $response = \Httpful\Request::post($url)->sendsJson()->body($this->encodeJsonWithOnlineAttribute($tableName, $this->getUnsyncedData($tableName)))->expectsJson()->timeout(60)->send();
                if ($response->body->membership_expired == true) {
                    $output["status"] = "ERROR";
                    $output["message"] = "Membership Expired";
                    $output["must_logout"] = true;
                    \Yii::$app->cache->set("EXPIRED", true);
                } else {
                    \Yii::$app->cache->set("EXPIRED", false);
                }
                \Yii::$app->cache->set("LAST_ONLINE", date("Y-m-d H:i:s"));
                \app\components\NodeLogger::sendLog("Body");
                \app\components\NodeLogger::sendLog($response->body);
                $db = \Yii::$app->db;
                $command = $db->createCommand();
                foreach ($response->body->output as $_item) {
                    $item = (array) $_item;
                    $updatedData = array("online_id" => $item["o_id"], "is_need_update" => 0);
                    $command->update($tableName, $updatedData, array("id" => $item["id"]))->execute();
                }
                $db->createCommand("COMMIT;")->execute();
                $serverTime = $response->body->time;
            } catch (\Httpful\Exception\ConnectionErrorException $exception) {
                $output["status"] = "ERROR";
                $output["message"] = "Tidak dapat terkoneksi dengan internet";
                break;
            }
        }
        if ($output["status"] == "OK") {
            \app\components\NodeLogger::sendLog("Updating Server Time");
            \app\models\Setting::setUpdateTime($serverTime);
        }
        return \yii\helpers\Json::encode($output);
    }
    private function getUnsyncedData($tableName)
    {
        $uTime = \app\models\Setting::getUpdateTime();
        $time = strtotime($uTime);
        $conditionTime = array("is_need_update" => 1, "jaringan_id" => \app\models\Jaringan::getCurrentID());
        switch ($tableName) {
            case "gudang":
                return \app\models\base\Gudang::find()->where($conditionTime)->all();
            case "jasa":
                return \app\models\base\Jasa::find()->where($conditionTime)->all();
            case "konsumen_group":
                return \app\models\base\KonsumenGroup::find()->where($conditionTime)->all();
            case "konsumen":
                return \app\models\base\Konsumen::find()->where($conditionTime)->all();
            case "rak":
                return \app\models\base\Rak::find()->where($conditionTime)->all();
            case "supplier":
                return \app\models\base\Supplier::find()->where($conditionTime)->all();
            case "absensi":
                return \app\models\base\Absensi::find()->where($conditionTime)->all();
            case "hari_aktif":
                return \app\models\base\HariAktif::find()->where($conditionTime)->all();
            case "perintah_kerja":
                return \app\models\base\PerintahKerja::find()->where($conditionTime)->all();
            case "perintah_kerja_jasa":
                return \app\models\base\PerintahKerjaJasa::find()->where($conditionTime)->all();
            case "perintah_kerja_suku_cadang":
                return \app\models\base\PerintahKerjaSukuCadang::find()->where($conditionTime)->all();
            case "purchase_order":
                return \app\models\base\PurchaseOrder::find()->where($conditionTime)->all();
            case "purchase_order_detail":
                return \app\models\base\PurchaseOrderDetail::find()->where($conditionTime)->all();
            case "nota_jasa":
                return \app\models\base\NotaJasa::find()->where($conditionTime)->all();
            case "nota_jasa_detail":
                return \app\models\base\NotaJasaDetail::find()->where($conditionTime)->all();
            case "penerimaan_part":
                return \app\models\base\PenerimaanPart::find()->where($conditionTime)->all();
            case "penerimaan_part_detail":
                return \app\models\base\PenerimaanPartDetail::find()->where($conditionTime)->all();
            case "pengeluaran_part":
                return \app\models\base\PengeluaranPart::find()->where($conditionTime)->all();
            case "pengeluaran_part_detail":
                return \app\models\base\PengeluaranPartDetail::find()->where($conditionTime)->all();
            case "stock_opname":
                return \app\models\base\StockOpname::find()->where($conditionTime)->all();
            case "stock_opname_detail":
                return \app\models\base\StockOpnameDetail::find()->where($conditionTime)->all();
            case "stock_opname_recount":
                return \app\models\base\StockOpnameRecount::find()->where($conditionTime)->all();
            case "suku_cadang_jaringan":
                return \app\models\base\SukuCadangJaringan::find()->where($conditionTime)->all();
            case "suku_cadang_kosong":
                return \app\models\base\SukuCadangKosong::find()->where($conditionTime)->all();
        }
    }
    private function encodeJsonWithOnlineAttribute($tableName, $dataArray)
    {
        $output = array();
        foreach ($dataArray as $item) {
            $string = \yii\helpers\Json::encode($item);
            $_item = \yii\helpers\Json::decode($string);
            $output[] = $this->processOnlineAttribute($tableName, $_item);
        }
        return \yii\helpers\Json::encode($output);
    }
    private function processOnlineAttribute($tableName, $data)
    {
        switch ($tableName) {
            case "gudang":
                break;
            case "jasa":
                break;
            case "konsumen_group":
                break;
            case "konsumen":
                $data = $this->processOnlineAttributeColumn($data, "konsumen_group_id", \app\models\base\KonsumenGroup::find());
                break;
            case "rak":
                $data = $this->processOnlineAttributeColumn($data, "gudang_id", \app\models\base\Gudang::find());
                break;
            case "supplier":
                break;
            case "absensi":
                break;
            case "hari_aktif":
                break;
            case "nota_jasa":
                $data = $this->processOnlineAttributeColumn($data, "perintah_kerja_id", \app\models\base\PerintahKerja::find());
                break;
            case "nota_jasa_detail":
                $data = $this->processOnlineAttributeColumn($data, "nota_jasa_id", \app\models\base\NotaJasa::find());
                $data = $this->processOnlineAttributeColumn($data, "jasa_id", \app\models\base\Jasa::find());
                break;
            case "penerimaan_part":
                $data = $this->processOnlineAttributeColumn($data, "supplier_id", \app\models\base\Supplier::find());
                $data = $this->processOnlineAttributeColumn($data, "purchase_order_id", \app\models\base\PurchaseOrder::find());
                break;
            case "penerimaan_part_detail":
                $data = $this->processOnlineAttributeColumn($data, "penerimaan_part_id", \app\models\base\PenerimaanPart::find());
                $data = $this->processOnlineAttributeColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "pengeluaran_part":
                $data = $this->processOnlineAttributeColumn($data, "no_referensi", \app\models\base\PerintahKerja::find());
                $data = $this->processOnlineAttributeColumn($data, "konsumen_id", \app\models\base\Konsumen::find());
                $data = $this->processOnlineAttributeColumn($data, "konsumen_penerima_id", \app\models\base\Konsumen::find());
                break;
            case "pengeluaran_part_detail":
                $data = $this->processOnlineAttributeColumn($data, "pengeluaran_part_id", \app\models\base\PengeluaranPart::find());
                $data = $this->processOnlineAttributeColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "perintah_kerja":
                $data = $this->processOnlineAttributeColumn($data, "konsumen_id", \app\models\base\Konsumen::find());
                break;
            case "perintah_kerja_jasa":
                $data = $this->processOnlineAttributeColumn($data, "perintah_kerja_id", \app\models\base\PerintahKerja::find());
                $data = $this->processOnlineAttributeColumn($data, "jasa_id", \app\models\base\Jasa::find());
                break;
            case "perintah_kerja_suku_cadang":
                $data = $this->processOnlineAttributeColumn($data, "perintah_kerja_id", \app\models\base\PerintahKerja::find());
                $data = $this->processOnlineAttributeColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "purchase_order":
                $data = $this->processOnlineAttributeColumn($data, "supplier_id", \app\models\base\Supplier::find());
                break;
            case "purchase_order_detail":
                break;
            case "stock_opname":
                break;
            case "stock_opname_detail":
                $data = $this->processOnlineAttributeColumn($data, "stock_opname_id", \app\models\base\StockOpname::find());
                $data = $this->processOnlineAttributeColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "stock_opname_recount":
                $data = $this->processOnlineAttributeColumn($data, "stock_opname_id", \app\models\base\StockOpname::find());
                $data = $this->processOnlineAttributeColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "suku_cadang_jaringan":
                $data = $this->processOnlineAttributeColumn($data, "gudang_id", \app\models\base\Gudang::find());
                $data = $this->processOnlineAttributeColumn($data, "rak_id", \app\models\base\Rak::find());
                break;
            case "suku_cadang_kosong":
                break;
        }
        return $data;
    }
    private function processOnlineAttributeColumn($data, $column, $query)
    {
        if (isset($data[$column]) && $data[$column] != null) {
            \app\components\NodeLogger::sendLog("=> Where ONLINE_ID " . $data[$column]);
            $model = $query->where(array("id" => $data[$column]))->one();
            \app\components\NodeLogger::sendLog($model);
            $data[$column . "_online_id"] = $model->online_id;
        }
        return $data;
    }
}

?>