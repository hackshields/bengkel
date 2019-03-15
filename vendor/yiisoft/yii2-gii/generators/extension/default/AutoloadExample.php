<?php

echo "<?php\n";
?>

namespace <?php 
echo substr($generator->namespace, 0, -1);
?>;

/**
 * This is just an example.
 */
class AutoloadExample extends \yii\base\Widget
{
    public function run()
    {
        return "Hello!";
    }
}
<?php 

?>