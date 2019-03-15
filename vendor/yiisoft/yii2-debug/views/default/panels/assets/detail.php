<?php

/* @var $panel yii\debug\panels\AssetPanel */
use yii\helpers\Html;
use yii\helpers\Inflector;
?>
<h1>Asset Bundles</h1>

<?php 
if (empty($panel->data)) {
    echo '<p>No asset bundle was used.</p>';
    return;
}
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <caption>
            <p>Total <b><?php 
echo count($panel->data);
?></b> asset bundles were loaded.</p>
        </caption>
    <?php 
foreach ($panel->data as $name => $bundle) {
    ?>
        <thead>
            <tr>
                <td colspan="2"><h3 id="<?php 
    echo Inflector::camel2id($name);
    ?>"><?php 
    echo $name;
    ?></h3></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>sourcePath</th>
                <td><?php 
    echo Html::encode($bundle['sourcePath'] !== null ? $bundle['sourcePath'] : $bundle['basePath']);
    ?></td>
            </tr>
            <?php 
    if ($bundle['basePath'] !== null) {
        ?>
                <tr>
                    <th>basePath</th>
                    <td><?php 
        echo Html::encode($bundle['basePath']);
        ?></td>
                </tr>
            <?php 
    }
    ?>
            <?php 
    if ($bundle['baseUrl'] !== null) {
        ?>
                <tr>
                    <th>baseUrl</th>
                    <td><?php 
        echo Html::encode($bundle['baseUrl']);
        ?></td>
                </tr>
            <?php 
    }
    ?>
            <?php 
    if (!empty($bundle['css'])) {
        ?>
            <tr>
                <th>css</th>
                <td><?php 
        echo Html::ul($bundle['css'], ['class' => 'assets']);
        ?></td>
            </tr>
            <?php 
    }
    ?>
            <?php 
    if (!empty($bundle['js'])) {
        ?>
            <tr>
                <th>js</th>
                <td><?php 
        echo Html::ul($bundle['js'], ['class' => 'assets']);
        ?></td>
            </tr>
            <?php 
    }
    ?>
            <?php 
    if (!empty($bundle['depends'])) {
        ?>
            <tr>
                <th>depends</th>
                <td><ul class="assets">
                    <?php 
        foreach ($bundle['depends'] as $depend) {
            ?>
                        <li><?php 
            echo Html::a($depend, '#' . Inflector::camel2id($depend));
            ?></li>
                    <?php 
        }
        ?>
                </ul></td>
            </tr>
            <?php 
    }
    ?>
        </tbody>
    <?php 
}
?>
    </table>
</div>
<?php 

?>