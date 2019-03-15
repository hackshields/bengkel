<?php

echo "    <div id=\"output\">\n        <div class=\"easyui-layout\" style=\"width:100%;height:600px\">\n            <div data-options=\"region:'north',border:true\" style=\"height:10%;padding: 10px\">\n                ";
$uploadData = Yii::$app->session->get("excel_upload");
if ($uploadData == NULL) {
    $form = yii\widgets\ActiveForm::begin(array("options" => array("enctype" => "multipart/form-data")));
    echo "\n                    ";
    echo $form->field($model, "imageFile")->fileInput();
    echo "\n                    <div class=\"row\">\n                        <div class=\"col-md-offset-3 col-md-10\">\n                            ";
    echo yii\helpers\Html::submitButton("Import", array("class" => "easyui-linkbutton", "id" => "btn_import"));
    echo "                        </div>\n                    </div>\n                    ";
} else {
    echo $uploadData->originalName . " ";
    echo yii\helpers\Html::a("Delete", array("delete-excel"), array("class" => "easyui-linkbutton", "id" => "btn_delete"));
}
echo "            </div>\n            ";
if ($uploadData != NULL) {
    echo "                <div data-options=\"region:'south',border:true\" style=\"height:90%;padding: 10px\">\n                    <div class=\"easyui-layout\" style=\"width:100%;height:100%\">\n                        <div data-options=\"region:'west',border:true,collapsible:false\"\n                             title=\"Pilih data yang ingin di-import\" style=\"height:100%;width: 40%;padding: 10px\">\n                            ";
    $form = yii\widgets\ActiveForm::begin(array("action" => yii\helpers\Url::to(array("process"))));
    echo "\n                            <div>\n                                ";
    echo app\components\EasyUI::combo($model2, "table", 400, $model2->getTableList());
    echo "                            </div>\n                            <div>\n                                ";
    echo app\components\EasyUI::combo($model2, "excel", 400, $model2->getSheetList());
    echo "                            </div>\n                            <div style=\"padding-left: 140px\">\n                                ";
    echo yii\helpers\Html::submitButton("Import", array("class" => "easyui-linkbutton"));
    echo "                            </div>\n\n                            ";
    yii\widgets\ActiveForm::end();
    echo "\n                            ";
    $log = Yii::$app->session->get("log_error", array());
    echo implode("<br>", $log);
    Yii::$app->session->set("log_error", array());
    $alert = Yii::$app->session->get("alert", "");
    if ($alert != "") {
        echo "<span style='font-size: 20px'>" . $alert . "</span>";
    }
    echo "                        </div>\n                        <div data-options=\"region:'east',border:true,collapsible:false\" title=\"Informasi data bengkel\"\n                             style=\"height:100%;width: 60%;padding: 10px\">\n                            <div>\n                                Supplier : <b>";
    echo app\components\Angka::toReadableAngka(app\models\Supplier::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Konsumen : <b>";
    echo app\components\Angka::toReadableAngka(app\models\Konsumen::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Suku Cadang : <b>";
    echo app\components\Angka::toReadableAngka(app\models\SukuCadangJaringan::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Jasa Servis : <b>";
    echo app\components\Angka::toReadableAngka(app\models\Jasa::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Karyawan : <b>";
    echo app\components\Angka::toReadableAngka(app\models\User::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Penerimaan Suku Cadang : <b>";
    echo app\components\Angka::toReadableAngka(app\models\PenerimaanPart::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Pengeluaran Suku Cadang : <b>";
    echo app\components\Angka::toReadableAngka(app\models\PengeluaranPart::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Stock Opname : <b>";
    echo app\components\Angka::toReadableAngka(app\models\StockOpname::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Absensi : <b>";
    echo app\components\Angka::toReadableAngka(app\models\Absensi::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Perintah Kerja : <b>";
    echo app\components\Angka::toReadableAngka(app\models\PerintahKerja::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                            <div>\n                                Nota Jasa : <b>";
    echo app\components\Angka::toReadableAngka(app\models\NotaJasa::find()->where(array("jaringan_id" => app\models\Jaringan::getCurrentID()))->count());
    echo "</b>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            ";
}
echo "        </div>\n    </div>\n\n";
$this->registerJs("\n\n\$(\"#output\").height(\$(window).height()-31);\n\n");

?>