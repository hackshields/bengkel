<?php

namespace app\models\search;

class MenuSearch extends \app\models\Menu
{
    public function rules()
    {
        return array(array(array("id", "order", "parent_id"), "integer"), array(array("name", "controller", "action", "icon"), "safe"));
    }
    public function scenarios()
    {
        return \yii\base\Model::scenarios();
    }
    public function search($params)
    {
        $query = \app\models\Menu::find();
        $dataProvider = new \yii\data\ActiveDataProvider(array("query" => $query));
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(array("id" => $this->id, "order" => $this->order, "parent_id" => $this->parent_id));
        $query->andFilterWhere(array("like", "name", $this->name))->andFilterWhere(array("like", "controller", $this->controller))->andFilterWhere(array("like", "action", $this->action))->andFilterWhere(array("like", "icon", $this->icon));
        return $dataProvider;
    }
}

?>