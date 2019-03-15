<?php

/* @var $panel yii\debug\panels\MailPanel */
/* @var $mailCount integer */
if ($mailCount) {
    ?>
<div class="yii-debug-toolbar-block">
    <a href="<?php 
    echo $panel->getUrl();
    ?>">Mail <span class="label"><?php 
    echo $mailCount;
    ?></span></a>
</div>
<?php 
}

?>