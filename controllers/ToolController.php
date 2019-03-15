<?php

namespace app\controllers;

class ToolController extends \yii\web\Controller
{
    public function actionIndex($q)
    {
        foreach (\Yii::$app->db->createCommand("show columns from " . $q)->queryAll() as $val) {
            echo "\"" . $val["Field"] . "\",<br>";
        }
    }
    public function actionImport($q)
    {
        foreach (\Yii::$app->db->createCommand("show columns from " . $q)->queryAll() as $val) {
            echo "\$x->" . $val["Field"] . " = \$item[0];<br>";
        }
    }
    public function actionInsert()
    {
        $absensi = new \app\models\Absensi();
        $absensi->jaringan_id = 1;
        $absensi->karyawan_id = 1;
        $absensi->jam_masuk = date("Y-m-d H:i:s");
        if (!$absensi->save()) {
            \app\components\NodeLogger::sendLog($absensi->errors);
        }
    }
    public function actionShowDatabase()
    {
        $connection = \Yii::$app->db;
        $dbSchema = $connection->schema;
        $tables = $dbSchema->tableSchemas;
        foreach ($tables as $tbl) {
            echo $tbl->name . " : <br>";
            foreach ($tbl->columns as $column) {
                echo "&nbsp;&nbsp;&nbsp;- " . $column->name . " => " . $column->dbType . "<br>";
            }
        }
    }
    public function actionCekSukuCadang($id)
    {
        $sukuCadang = \app\models\SukuCadang::find()->where(array("id" => $id))->one();
        echo \yii\helpers\Json::encode($sukuCadang->sukuCadangJaringan);
    }
    public function actionPratama()
    {
        $trans = \Yii::$app->db->beginTransaction();
        foreach (\app\models\Jasa::find()->where(array("jaringan_id" => 1, "status" => 1))->all() as $jasa) {
            $jasa->isNewRecord = true;
            $jasa->id = null;
            $jasa->jaringan_id = 2;
            $jasa->save();
        }
        foreach (\app\models\SukuCadangJaringan::find()->where(array("jaringan_id" => 1))->all() as $skj) {
            $skj->isNewRecord = true;
            $skj->id = null;
            $skj->jaringan_id = 2;
            $skj->save();
        }
        $trans->commit();
    }
    public function actionServisTerakhir()
    {
        foreach (\app\models\Konsumen::find()->where("service_terakhir is null")->all() as $konsumen) {
            $konsumen->service_terakhir = $konsumen->created_at;
            $konsumen->save();
        }
    }
    public function actionProsesHet()
    {
        ini_set("memory_limit", "8000M");
        set_time_limit(0);
        $allSc = \app\models\SukuCadang::find()->all();
        $i = 1;
        foreach ($allSc as $sukuCadang) {
            $all = \app\models\PenerimaanPartDetail::find()->joinWith(array("penerimaanPart" => function ($query) {
                $query->orderBy("tanggal_penerimaan")->where(array("penerimaan_part.jaringan_id" => \app\models\Jaringan::getCurrentID()));
            }))->where(array("suku_cadang_id" => $sukuCadang->id))->all();
            $total = 0;
            $jumlah = 0;
            foreach ($all as $detail) {
                $total += $detail->harga_beli * $detail->quantity_supp;
                $jumlah += $detail->quantity_supp;
            }
            if ($jumlah != 0) {
                $sc = \app\models\SukuCadangJaringan::find()->where(array("suku_cadang_id" => $sukuCadang->id, "jaringan_id" => \app\models\Jaringan::getCurrentID()))->one();
                if ($sc != null) {
                    $sc->hpp = $total / $jumlah;
                    $sc->save();
                }
            }
            \app\components\NodeLogger::sendLog($i . " of " . count($allSc) . " " . $sukuCadang->kode . " - " . $sukuCadang->nama);
            $i++;
        }
    }
}

?>