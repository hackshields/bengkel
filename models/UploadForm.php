<?php

namespace app\models;

class UploadForm extends \yii\base\Model
{
    public $imageFile = NULL;
    public $fileName = NULL;
    public $originalName = NULL;
    public $sheets = NULL;
    public $sheetFiles = array();
    public function rules()
    {
        return array(array(array("imageFile"), "file", "skipOnEmpty" => false, "extensions" => "xlsx"));
    }
    public function upload()
    {
        if ($this->validate()) {
            $this->originalName = $this->imageFile->baseName . ".xlsx";
            $fileName = "excel/" . $this->imageFile->baseName . "_" . \Yii::$app->security->generateRandomString(6) . ".xlsx";
            $this->imageFile->saveAs($fileName);
            $this->fileName = $fileName;
            $this->separateSheets();
            return true;
        }
        return false;
    }
    private function separateSheets()
    {
        \app\components\NodeLogger::sendLog("Begin Load");
        $list = array();
        $inputFileType = \PHPExcel_IOFactory::identify($this->fileName);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($this->fileName);
        \app\components\NodeLogger::sendLog("Loaded Done");
        $id = 0;
        foreach ($objPHPExcel->getAllSheets() as $sheet) {
            $list[$id] = $sheet->getTitle();
            \app\components\NodeLogger::sendLog("Processing " . $sheet->getTitle());
            $newName = $this->fileName . "_" . $id . ".csv";
            $this->sheetFiles[] = $newName;
            \app\components\NodeLogger::sendLog("Begin PHPExcel");
            \app\components\NodeLogger::sendLog("Add Sheet");
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "CSV");
            $objWriter->setSheetIndex($id);
            $objWriter->setDelimiter(";");
            \app\components\NodeLogger::sendLog("Save New");
            $objWriter->save($newName);
            \app\components\NodeLogger::sendLog("End PHPExcel");
            $id++;
        }
        $this->sheets = $list;
    }
}

?>