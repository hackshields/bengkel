<?php

/**
 * This is the template for generating the ActiveQuery class.
 */
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $className string class name */
/* @var $modelClassName string related model class name */
$modelFullClassName = $modelClassName;
if ($generator->ns !== $generator->queryNs) {
    $modelFullClassName = '\\' . $generator->ns . '\\' . $modelFullClassName;
}
echo "<?php\n";
?>

namespace <?php 
echo $generator->queryNs;
?>;

/**
 * This is the ActiveQuery class for [[<?php 
echo $modelFullClassName;
?>]].
 *
 * @see <?php 
echo $modelFullClassName . "\n";
?>
 */
class <?php 
echo $className;
?> extends <?php 
echo '\\' . ltrim($generator->queryBaseClass, '\\') . "\n";
?>
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return <?php 
echo $modelFullClassName;
?>[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return <?php 
echo $modelFullClassName;
?>|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
<?php 

?>