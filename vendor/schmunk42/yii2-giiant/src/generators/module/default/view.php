<?php

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */
?>

<?php 
echo "<?php";
?>

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Inflector;

/*
 * @var yii\web\View $this
 */
$controllers = \dmstr\helpers\Metadata::getModuleControllers($this->context->module->id);
$favourites  = [];

$patterns = [
    '^.*$'          => ['color' => 'blue', 'icon' => FA::_CUBE],
];

foreach ($patterns AS $pattern => $options) {
    foreach ($controllers AS $c => $item) {
        $controllers[$c]['label'] = $item['name'];
        if (preg_match("/$pattern/", $item['name'])) {
            $favourites[$c]          = $item;
            $favourites[$c]['label'] = $item['name'];
            $favourites[$c]['color'] = $options['color'];
            $favourites[$c]['icon']  = isset($options['icon']) ? $options['icon'] : null;
            unset($controllers[$c]);
        }
    }
}
?>

<?php 
echo "<?= \$this->render(\n    '@vendor/dmstr/yii2-adminlte-asset/example-views/phundament/app/default/_controllers.php',\n    [\n        'controllers'    => \$controllers,\n        'favourites'     => \$favourites,\n        'modelNamespace' => 'app\\models\\\\',\n    ]\n) ?>\n";

?>