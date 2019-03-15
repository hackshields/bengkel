<?php

/* @var $panel yii\debug\panels\DbPanel */
/* @var $queryCount integer */
/* @var $queryTime integer */
if ($queryCount) {
    ?>
<div class="yii-debug-toolbar-block">
    <a href="<?php 
    echo $panel->getUrl();
    ?>" title="Executed <?php 
    echo $queryCount;
    ?> database queries which took <?php 
    echo $queryTime;
    ?>.">
        <?php 
    echo $panel->getSummaryName();
    ?> <span class="label label-info"><?php 
    echo $queryCount;
    ?></span> <span class="label"><?php 
    echo $queryTime;
    ?></span>
    </a>
</div>
<?php 
}

?>