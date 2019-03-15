<?php

use yii\helpers\StringHelper;
/**
 * This is the template for generating a CRUD controller class file.
 *
 * @var yii\web\View $this
 * @var schmunk42\giiant\generators\crud\Generator $generator
 */
$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}
$pks = $generator->getTableSchema()->primaryKey;
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
echo "<?php\n";
?>

namespace <?php 
echo StringHelper::dirname(ltrim($generator->controllerClass, '\\'));
?>;

use <?php 
echo ltrim($generator->modelClass, '\\');
?>;
use <?php 
echo ltrim($generator->baseControllerClass, '\\');
?>;
use yii\web\HttpException;
use yii\helpers\Json;
use app\models\User;

class <?php 
echo $controllerClass;
?> extends <?php 
echo StringHelper::basename($generator->baseControllerClass) . "\n";
?>
{
    public $enableCsrfValidation = false;

    public function actionList()
    {
        return $this->renderAjax("list");
    }

    public function actionListData()
    {
        $page = $_POST['page'];
        $rows = $_POST['rows'];

        if ($page == null) {
            $page = 1;
        }
        if ($rows == null) {
            $rows = 10;
        }

        /** @var User $user */
        $user = \Yii::$app->user->identity;
        $query = <?php 
echo $modelClass;
?>::find()->where(["jaringan_id" => $user->jaringan_id, "status"=>"1"]);
        $arr = $query->offset(($page - 1) * $rows)->limit($rows)->all();

        $output = [
            "rows" => $arr,
            "total" => $query->count()
        ];

        echo Json::encode($output);
    }

    public function actionSave($id = null)
    {
        if ($id == null) {
            $model = new <?php 
echo $modelClass;
?>();

            if ($model->load($_POST)) {
                if ($model->save()) {
                    return Json::encode(["status"=>"OK"]);
                } else {
                    return Json::encode(["status"=>"ERROR", "error" => $model->errors]);
                }
            }
        }else{
            $model = <?php 
echo $modelClass;
?>::find()->where(["id"=>$id])->one();

            if ($model->load($_POST)) {
                if ($model->save()) {
                    return Json::encode(["status"=>"OK"]);
                } else {
                    return Json::encode(["status"=>"ERROR", "error" => $model->errors]);
                }
            }
        }
    }



    public function actionDelete($id){
        /**
        * @var $model <?php 
echo $modelClass;
?>
        */
        $model = <?php 
echo $modelClass;
?>::find()->where(["id"=>$id])->one();
        $model->status = 0;
        $model->save();
    }
}
<?php 

?>