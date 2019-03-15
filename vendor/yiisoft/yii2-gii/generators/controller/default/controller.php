<?php

/**
 * This is the template for generating a controller class file.
 */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */
echo "<?php\n";
?>

namespace <?php 
echo $generator->getControllerNamespace();
?>;

class <?php 
echo StringHelper::basename($generator->controllerClass);
?> extends <?php 
echo '\\' . trim($generator->baseClass, '\\') . "\n";
?>
{
<?php 
foreach ($generator->getActionIDs() as $action) {
    ?>
    public function action<?php 
    echo Inflector::id2camel($action);
    ?>()
    {
        return $this->render('<?php 
    echo $action;
    ?>');
    }

<?php 
}
?>
}
<?php 

?>