<?php

namespace app\controllers;

class SeminarKonsultasiController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
}

?>