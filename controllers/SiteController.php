<?php

namespace app\controllers;

class SiteController extends \yii\web\Controller
{
    public function behaviors()
    {
        return \app\models\Action::getAccess($this->id);
    }
    public function actions()
    {
        return array("error" => array("class" => "yii\\web\\ErrorAction"), "captcha" => array("class" => "yii\\captcha\\CaptchaAction", "fixedVerifyCode" => YII_ENV_TEST ? "testme" : null));
    }
    public function actionEmpty()
    {
        return $this->renderPartial("empty");
    }
    public function actionIndex()
    {
        return $this->render("index");
    }
    public function actionProfile()
    {
        $model = \app\models\User::find()->where(array("id" => \Yii::$app->user->id))->one();
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
            return $this->redirect(array("profile"));
        }
        return $this->render("profile", array("model" => $model));
    }
    public function actionRegister()
    {
        $this->layout = "main-login";
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new \app\models\RegisterForm();
        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            \Yii::$app->session->addFlash("success", "Register success, please login");
            return $this->redirect(array("site/login"));
        }
        return $this->render("register", array("model" => $model));
    }
    public function actionLogin()
    {
        $this->layout = "main-login";
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new \app\models\LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            $user = \Yii::$app->user->identity;
            $user->last_login = new \yii\db\Expression("NOW()");
            $user->save();
            return $this->goBack();
        }
        return $this->render("login", array("model" => $model));
    }
    public function actionLogout()
    {
        $user = \Yii::$app->user->identity;
        $user->last_logout = new \yii\db\Expression("NOW()");
        $user->save();
        \Yii::$app->user->logout();
        return $this->goHome();
    }
    public function actionContact()
    {
        $model = new \app\models\ContactForm();
        if ($model->load(\Yii::$app->request->post()) && $model->contact(\Yii::$app->params["adminEmail"])) {
            \Yii::$app->session->setFlash("contactFormSubmitted");
            return $this->refresh();
        }
        return $this->render("contact", array("model" => $model));
    }
    public function actionAbout()
    {
        return $this->render("about");
    }
}

?>