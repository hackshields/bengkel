<?php

use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */
/** @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass();
$model->setScenario('crud');
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->getTableSchema()->columnNames;
}
echo "<?php\n";
?>
use \yii\helpers\Url;
use app\components\EasyUI;

$model = new <?php 
echo ltrim($generator->modelClass, '\\');
?>();
?>
<div class="easyui-layout" style="width:100%;height:100%;">
    <div data-options="region:'north'" style="height:50%;overflow: hidden">
        <table id="tt"
               class="easyui-datagrid" style="width:100%;height:100%"
               url="<?php 
echo "<?=";
?> \yii\helpers\Url::to(["list-data"]) ?>"
               title="Data <?php 
echo \yii\helpers\Inflector::camel2words(StringHelper::basename($generator->modelClass));
?>"
               rownumbers="true" pagination="true">
            <thead>
                <tr>
                    <?php 
foreach ($safeAttributes as $attribute) {
    if ($attribute != "id" && $attribute != "status" && $attribute != "created_at" && $attribute != "created_by" && $attribute != "updated_at" && $attribute != "updated_by") {
        $label = $model->getAttributeLabel($attribute);
        echo "<th field=\"" . $attribute . "\" width=\"80\">" . $label . "</th>\n\t\t\t\t\t";
    }
}
?>
</tr>
            </thead>
        </table>
    </div>
    <div data-options="region:'center'" style="height:40%;padding: 10px 20px">
        <form id="form" method="post" action="">
            <div class="form-control">
                <?php 
foreach ($safeAttributes as $attribute) {
    if ($attribute != "id" && $attribute != "status" && $attribute != "created_at" && $attribute != "created_by" && $attribute != "updated_at" && $attribute != "updated_by") {
        echo "<div class=\"form-control\">\n\t\t\t\t";
        echo "<?= EasyUI::input(\$model, \"" . $attribute . "\", 300); ?>\n\t\t\t\t";
        echo "</div>\n\t\t\t\t";
    }
}
?>
</div>
        </form>
    </div>
    <div data-options="region:'south'" style="height:10%;padding: 10px 20px">
        <a href="javascript:void(0)" id="btn-save" class="easyui-linkbutton" data-options="iconCls:'icon-save'">Simpan</a>
        <a href="javascript:void(0)" id="btn-delete" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">Hapus</a>
    </div>
</div>

<script>
    var selectedData = {};
    var currentID = "";

    $("#tt").datagrid({
        onClickRow: function(index, row){
            selectedData = row;
            console.log(row);
            for (var property in selectedData) {
                if (selectedData.hasOwnProperty(property)) {
                    //console.log(property, selectedData[property])
                    $("#"+property).setValue(selectedData[property]);
                }
            }
            currentID = selectedData.id;
        }
    });

    $("#btn-save").click(function(){
        var serialize = $("#form").serialize();
        console.log(serialize);
        $.ajax({
            url : "<?php 
echo "<?=";
?> Url::to(["save"]) ?>?id=" + currentID,
            data : serialize,
            type : "post",
            success : function(msg){
                dialog("Simpan Data Sukses");
                $('#tt').datagrid('reload');
            }
        });
        return false;
    });
    $("#btn-delete").click(function(){
        $.ajax({
            url : "<?php 
echo "<?=";
?> Url::to(["delete"]) ?>?id=" + currentID,
            data : $("#form").serialize(),
            success : function(msg){
                dialog("Hapus Data Sukses");
                $('#tt').datagrid('reload');
                currentID = "";
                $("#form").form("clear");
            }
        });
        return false;
    });
</script><?php 

?>