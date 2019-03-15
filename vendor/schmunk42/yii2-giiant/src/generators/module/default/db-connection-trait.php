<?php

/**
 * This is the template for generating a controller class within a module.
 */
/* @var $this yii\web\View */
/* @var $generator schmunk42\giiant\generators\module\Generator */
echo "<?php\n";
?>

namespace <?php 
echo $generator->getTraitsNamespace();
?>;

trait ActiveRecordDbConnectionTrait
{
    public static function getDb()
    {
        return \Yii::$app->db;
    }
}
<?php 

?>