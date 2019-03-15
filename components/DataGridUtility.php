<?php

namespace app\components;

class DataGridUtility
{
    public static function process($query)
    {
        $page = $_POST["page"];
        $rows = $_POST["rows"];
        $q = $_POST["query"];
        if ($page == null) {
            $page = 1;
        }
        if ($rows == null) {
            $rows = 10;
        }
        if (isset($q)) {
            $q = trim($q);
            $arrQuery = explode(" ", $q);
            foreach ($arrQuery as $que) {
                if ($que == "") {
                    continue;
                }
                $likeParams = array("or");
                $cls = $query->modelClass;
                $obj = new $cls();
                foreach ($obj->attributes as $key => $value) {
                    $likeParams[] = array("like", $key, $que);
                }
                $query->andFilterWhere($likeParams);
            }
        }
        $arr = $query->offset(($page - 1) * $rows)->limit($rows)->all();
        $output = array("rows" => $arr, "total" => $query->count());
        return \yii\helpers\Json::encode($output);
    }
}

?>