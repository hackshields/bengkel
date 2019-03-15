<?php

namespace app\controllers;

class UserController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return \app\models\Action::getAccess($this->id);
    }
    public function actionIndex()
    {
        $searchModel = new \app\models\search\UserSearch();
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
        $model = new \app\models\User();
        try {
            if ($model->load($_POST)) {
                $model->password = md5($model->password);
                $image = \yii\web\UploadedFile::getInstance($model, "photo_url");
                if ($image != NULL) {
                    $model->photo_url = $image->name;
                    $extension = end(explode(".", $image->name));
                    $model->photo_url = \Yii::$app->security->generateRandomString() . "." . $extension;
                    $path = \Yii::getAlias("@app/web/uploads/") . $model->photo_url;
                    $image->saveAs($path);
                } else {
                    $model->photo_url = "default.png";
                }
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
        $oldMd5Password = $model->password;
        $oldPhotoUrl = $model->photo_url;
        $model->password = "";
        if ($model->load($_POST)) {
            if ($model->password != "") {
                $model->password = md5($model->password);
            } else {
                $model->password = $oldMd5Password;
            }
            $image = \yii\web\UploadedFile::getInstance($model, "photo_url");
            if ($image != NULL) {
                $model->photo_url = $image->name;
                $arr = explode(".", $image->name);
                $extension = end($arr);
                $model->photo_url = \Yii::$app->security->generateRandomString() . "." . $extension;
                $path = \Yii::getAlias("@app/web/uploads/") . $model->photo_url;
                $image->saveAs($path);
            } else {
                $model->photo_url = $oldPhotoUrl;
            }
            if ($model->save()) {
                \Yii::$app->session->addFlash("success", "Profile successfully updated.");
            } else {
                \Yii::$app->session->addFlash("danger", "Profile cannot updated.");
            }
            return $this->redirect(array("index"));
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
    protected function findModel($id)
    {
        if (($model = \app\models\User::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\HttpException(404, "The requested page does not exist.");
    }
}

?>