<?php

namespace app\models\search;

class RoleSearch extends \app\models\Role
{
    public function rules()
    {
        return array(array(array("id"), "integer"), array(array("name"), "safe"));
    }
    public function scenarios()
    {
        return \yii\base\Model::scenarios();
    }
    public function search($params)
    {
        $query = \app\models\Role::find();
        $dataProvider = new \yii\data\ActiveDataProvider(array("query" => $query));
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(array("id" => $this->id));
        $query->andFilterWhere(array("like", "name", $this->name));
        return $dataProvider;
    }
}

?>