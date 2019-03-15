<?php

namespace app\controllers;

class SukuCadangAdjustController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionProcess($percentage)
    {
        foreach (\app\models\SukuCadangJaringan::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()))->all() as $scj) {
            $sukuCadang = $scj->sukuCadang;
            $hargaFinal = $percentage / 100 * $sukuCadang->het;
            if ($hargaFinal != $scj->harga_jual) {
                echo "<b>" . $sukuCadang->nama . "</b>:<br>";
                echo \app\components\Angka::toReadableHarga($scj->harga_jual) . " => " . \app\components\Angka::toReadableHarga($hargaFinal) . "<br>";
                $scj->harga_jual = $hargaFinal;
                $scj->save();
            }
        }
    }
}

?>