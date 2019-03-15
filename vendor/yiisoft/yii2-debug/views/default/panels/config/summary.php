<?php

/* @var $panel yii\debug\panels\ConfigPanel */
?>
<div class="yii-debug-toolbar-block">
    <a href="<?php 
echo $panel->getUrl();
?>">
        Yii
        <span class="label"><?php 
echo $panel->data['application']['yii'];
?></span>
        PHP
        <span class="label"><?php 
echo $panel->data['php']['version'];
?></span>
    </a>
</div>
<?php 

?>