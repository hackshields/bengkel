<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\gii\components\ActiveField;
use yii\gii\CodeFile;
/* @var $this yii\web\View */
/* @var $generator yii\gii\Generator */
/* @var $id string panel ID */
/* @var $form yii\widgets\ActiveForm */
/* @var $results string */
/* @var $hasError boolean */
/* @var $files CodeFile[] */
/* @var $answers array */
$this->title = $generator->getName();
$templates = [];
foreach ($generator->templates as $name => $path) {
    $templates[$name] = "{$name} ({$path})";
}
?>
<div class="default-view">
    <h1><?php 
echo Html::encode($this->title);
?></h1>

    <p><?php 
echo $generator->getDescription();
?></p>

    <?php 
$form = ActiveForm::begin(['id' => "{$id}-generator", 'successCssClass' => '', 'fieldConfig' => ['class' => ActiveField::className()]]);
?>
        <div class="row">
            <div class="col-lg-8 col-md-10">
                <?php 
echo $this->renderFile($generator->formView(), ['generator' => $generator, 'form' => $form]);
?>
                <?php 
echo $form->field($generator, 'template')->sticky()->label('Code Template')->dropDownList($templates)->hint('
                        Please select which set of the templates should be used to generated the code.
                ');
?>
                <div class="form-group">
                    <?php 
echo Html::submitButton('Preview', ['name' => 'preview', 'class' => 'btn btn-primary']);
?>

                    <?php 
if (isset($files)) {
    ?>
                        <?php 
    echo Html::submitButton('Generate', ['name' => 'generate', 'class' => 'btn btn-success']);
    ?>
                    <?php 
}
?>
                </div>
            </div>
        </div>

        <?php 
if (isset($results)) {
    echo $this->render('view/results', ['generator' => $generator, 'results' => $results, 'hasError' => $hasError]);
} elseif (isset($files)) {
    echo $this->render('view/files', ['id' => $id, 'generator' => $generator, 'files' => $files, 'answers' => $answers]);
}
?>
    <?php 
ActiveForm::end();
?>
</div>
<?php 

?>