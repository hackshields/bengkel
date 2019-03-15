<?php

/* @var $panel yii\debug\panels\ProfilingPanel */
/* @var $time integer */
/* @var $memory integer */
?>
<div class="yii-debug-toolbar-block">
    <a href="<?php 
echo $panel->getUrl();
?>" title="Total request processing time was <?php 
echo $time;
?>">Time <span class="label label-info"><?php 
echo $time;
?></span></a>
    <a href="<?php 
echo $panel->getUrl();
?>" title="Peak memory consumption">Memory <span class="label label-info"><?php 
echo $memory;
?></span></a>
</div>
<?php 

?>