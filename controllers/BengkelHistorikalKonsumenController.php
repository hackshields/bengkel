<?php

namespace app\controllers;

class BengkelHistorikalKonsumenController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public $konsumen_id = NULL;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionListKonsumen()
    {
        $query = \app\models\Konsumen::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()));
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListJasa($id = NULL)
    {
        if ($id == null) {
            $query = \app\models\NotaJasaDetail::find()->where("id is null");
        } else {
            $this->konsumen_id = $id;
            $query = \app\models\NotaJasaDetail::find()->joinWith(array("notaJasa" => function ($qHeader) {
                $qHeader->joinWith(array("perintahKerja" => function ($qqHeader) {
                    $qqHeader->where(array("perintah_kerja.konsumen_id" => $this->konsumen_id));
                }));
                $qHeader->andWhere(array("nota_jasa.jaringan_id" => \app\models\Jaringan::getCurrentID()));
            }));
        }
        return \app\components\DataGridUtility::process($query);
    }
    public function actionListSukuCadang($id = NULL)
    {
        if ($id == null) {
            $query = \app\models\PengeluaranPartDetail::find()->where("id is null");
        } else {
            $this->konsumen_id = $id;
            $query = \app\models\PengeluaranPartDetail::find()->joinWith(array("pengeluaranPart" => function ($qHeader) {
                $qHeader->where(array("pengeluaran_part.konsumen_id" => $this->konsumen_id, "pengeluaran_part.jaringan_id" => \app\models\Jaringan::getCurrentID()));
            }));
        }
        return \app\components\DataGridUtility::process($query);
    }
}

?>