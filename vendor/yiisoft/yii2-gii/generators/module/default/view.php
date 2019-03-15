<?php

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */
?>
<div class="<?php 
echo $generator->moduleID . '-default-index';
?>">
    <h1><?php 
echo "<?= ";
?>$this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?php 
echo "<?= ";
?>$this->context->action->id ?>".
        The action belongs to the controller "<?php 
echo "<?= ";
?>get_class($this->context) ?>"
        in the "<?php 
echo "<?= ";
?>$this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?php 
echo "<?= ";
?>__FILE__ ?></code>
    </p>
</div>
<?php 

?>