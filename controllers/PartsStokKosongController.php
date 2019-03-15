<?php

namespace app\controllers;

class PartsStokKosongController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionList()
    {
        $query = \app\models\ViewStokKosong::find()->where(array("jaringan_id" => \app\models\Jaringan::getCurrentID()));
        return \app\components\DataGridUtility::process($query);
    }
}

?>