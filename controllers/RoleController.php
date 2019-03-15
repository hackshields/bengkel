<?php

namespace app\controllers;

class RoleController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return \app\models\Action::getAccess($this->id);
    }
    public function actionIndex()
    {
        $searchModel = new \app\models\search\RoleSearch();
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
        $model = new \app\models\Role();
        try {
            if ($model->load($_POST) && $model->save()) {
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
    public function actionDetail($id)
    {
        $model = $this->findModel($id);
        if (isset($_POST["menu"])) {
            \app\models\RoleMenu::deleteAll(array("role_id" => $id));
            $menus = $_POST["menu"];
            foreach ($menus as $menu) {
                $roleMenu = new \app\models\RoleMenu();
                $roleMenu->role_id = $id;
                $roleMenu->menu_id = $menu;
                $roleMenu->save();
            }
            \app\models\RoleAction::deleteAll(array("role_id" => $id));
            $actions = $_POST["action"];
            if (isset($actions)) {
                foreach ($actions as $action) {
                    $roleMenu = new \app\models\RoleAction();
                    $roleMenu->role_id = $id;
                    $roleMenu->action_id = $action;
                    $roleMenu->save();
                }
            }
            \Yii::$app->session->addFlash("success", "Role " . $model->name . " successfully updated.");
            return $this->redirect(array("index"));
        } else {
            return $this->render("detail", array("model" => $model));
        }
    }
    protected function findModel($id)
    {
        if (($model = \app\models\Role::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\HttpException(404, "The requested page does not exist.");
    }
}

?>