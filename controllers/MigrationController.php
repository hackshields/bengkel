<?php

namespace app\controllers;

class MigrationController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }
    public function actionUpdateGit()
    {
        echo "Update Git...";
    }
    public function actionMigration()
    {
        echo "Migrating..";
    }
}

?>