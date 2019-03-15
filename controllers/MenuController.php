<?php

namespace app\controllers;

class MenuController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return \app\models\Action::getAccess($this->id);
    }
    public function actionIndex()
    {
        $searchModel = new \app\models\search\MenuSearch();
        $dataProvider = $searchModel->search($_GET);
        \dmstr\bootstrap\Tabs::clearLocalStorage();
        \yii\helpers\Url::remember();
        \Yii::$app->session["__crudReturnUrl"] = null;
        return $this->render("index", array("dataProvider" => $dataProvider, "searchModel" => $searchModel));
    }
    public function actionView($id)
    {
        \Yii::$app->session["__crudReturnUrl"] = \yii\helpers\Url::previous();
        \yii\helpers\Url::remember();
        \dmstr\bootstrap\Tabs::rememberActiveState();
        return $this->render("view", array("model" => $this->findModel($id)));
    }
    public function actionCreate()
    {
        $model = new \app\models\Menu();
        try {
            if ($model->load($_POST)) {
                $model->icon = "fa " . $model->icon;
                $model->save();
                return $this->redirect(\yii\helpers\Url::previous());
            }
            if (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = isset($e->errorInfo[2]) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError("_exception", $msg);
        }
        return $this->render("create", array("model" => $model));
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load($_POST) && $model->save()) {
            return $this->redirect(\yii\helpers\Url::previous());
        }
        return $this->render("update", array("model" => $model));
    }
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (\Exception $e) {
            $msg = isset($e->errorInfo[2]) ? $e->errorInfo[2] : $e->getMessage();
            \Yii::$app->getSession()->setFlash("error", $msg);
            return $this->redirect(\yii\helpers\Url::previous());
        }
        $isPivot = strstr("\$id", ",");
        if ($isPivot == true) {
            return $this->redirect(\yii\helpers\Url::previous());
        }
        if (isset(\Yii::$app->session["__crudReturnUrl"]) && \Yii::$app->session["__crudReturnUrl"] != "/") {
            \yii\helpers\Url::remember(null);
            $url = \Yii::$app->session["__crudReturnUrl"];
            \Yii::$app->session["__crudReturnUrl"] = null;
            return $this->redirect($url);
        }
        return $this->redirect(array("index"));
    }
    public function actionSave()
    {
        $str = $_POST["str"];
        $trs = explode("||", $str);
        $no = 1;
        foreach ($trs as $tr) {
            $obj = explode("[=]", $tr);
            $menu = \app\models\Menu::find()->where(array("id" => $obj[0]))->one();
            list(, $menu->name, $menu->controller, $menu->parent_id) = $obj;
            $menu->order = $no;
            $menu->icon = "fa " . $obj[4];
            $menu->save();
            $no++;
        }
    }
    protected function findModel($id)
    {
        if (($model = \app\models\Menu::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\HttpException(404, "The requested page does not exist.");
    }
}

?>