<?php

/* @var $this \yii\web\View */
/* @var $panels \yii\debug\Panel[] */
/* @var $tag string */
/* @var $position string */
use yii\helpers\Url;
$minJs = <<<EOD
document.getElementById('yii-debug-toolbar').style.display = 'none';
document.getElementById('yii-debug-toolbar-min').style.display = 'block';
if (window.localStorage) {
    localStorage.setItem('yii-debug-toolbar', 'minimized');
}
EOD;
$maxJs = <<<EOD
document.getElementById('yii-debug-toolbar-min').style.display = 'none';
document.getElementById('yii-debug-toolbar').style.display = 'block';
if (window.localStorage) {
    localStorage.setItem('yii-debug-toolbar', 'maximized');
}
EOD;
$firstPanel = reset($panels);
$url = $firstPanel->getUrl();
?>
<div id="yii-debug-toolbar" class="yii-debug-toolbar-<?php 
echo $position;
?> hidden-print">
    <div class="yii-debug-toolbar-block title">
        <a href="<?php 
echo Url::to(['index']);
?>">
            <img width="29" height="30" alt="" src="<?php 
echo \yii\debug\Module::getYiiLogo();
?>">
            Yii Debugger
        </a>
    </div>

    <?php 
foreach ($panels as $panel) {
    ?>
        <?php 
    echo $panel->getSummary();
    ?>
    <?php 
}
?>
    <span class="yii-debug-toolbar-toggler" onclick="<?php 
echo $minJs;
?>">›</span>
</div>
<div id="yii-debug-toolbar-min" class="hidden-print">
    <a href="<?php 
echo $url;
?>" title="Open Yii Debugger" id="yii-debug-toolbar-logo">
        <img width="29" height="30" alt="" src="<?php 
echo \yii\debug\Module::getYiiLogo();
?>">
    </a>
    <span class="yii-debug-toolbar-toggler" onclick="<?php 
echo $maxJs;
?>">‹</span>
</div>
<?php 

?>