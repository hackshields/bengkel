<?php

/**
 * This is the template for generating an action view file.
 */
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\form\Generator */
echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?php 
echo $generator->modelClass;
?> */
/* @var $form ActiveForm */
<?php 
echo "?>";
?>

<div class="<?php 
echo str_replace('/', '-', trim($generator->viewName, '_'));
?>">

    <?php 
echo "<?php ";
?>$form = ActiveForm::begin(); ?>

    <?php 
foreach ($generator->getModelAttributes() as $attribute) {
    ?>
    <?php 
    echo "<?= ";
    ?>$form->field($model, '<?php 
    echo $attribute;
    ?>') ?>
    <?php 
}
?>

        <div class="form-group">
            <?php 
echo "<?= ";
?>Html::submitButton(<?php 
echo $generator->generateString('Submit');
?>, ['class' => 'btn btn-primary']) ?>
        </div>
    <?php 
echo "<?php ";
?>ActiveForm::end(); ?>

</div><!-- <?php 
echo str_replace('/', '-', trim($generator->viewName, '-'));
?> -->
<?php 

?>