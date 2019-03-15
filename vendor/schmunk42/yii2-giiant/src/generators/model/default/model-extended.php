<?php

/**
 * This is the template for generating the model class of a specified table.
 *
 * @var yii\web\View $this
 * @var yii\gii\generators\model\Generator $generator
 * @var string $tableName full table name
 * @var string $className class name
 * @var yii\db\TableSchema $tableSchema
 * @var string[] $labels list of attribute labels (name => label)
 * @var string[] $rules list of validation rules
 * @var array $relations list of relations (name => relation declaration)
 */
echo "<?php\n";
?>

namespace <?php 
echo $generator->ns;
?>;

use Yii;
use \<?php 
echo $generator->ns;
?>\base\<?php 
echo $className;
?> as Base<?php 
echo $className;
?>;

/**
 * This is the model class for table "<?php 
echo $tableName;
?>".
 */
class <?php 
echo $className;
?> extends Base<?php 
echo $className . "\n";
?>
{
}
<?php 

?>