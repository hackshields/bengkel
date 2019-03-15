<?php

namespace app\models\search;

class UserSearch extends \app\models\User
{
    public function rules()
    {
        return array(array(array("id", "role_id"), "integer"), array(array("username", "password", "name", "photo_url", "last_login", "last_logout"), "safe"));
    }
    public function scenarios()
    {
        return \yii\base\Model::scenarios();
    }
    public function search($params)
    {
        $query = \app\models\User::find();
        $dataProvider = new \yii\data\ActiveDataProvider(array("query" => $query));
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(array("id" => $this->id, "role_id" => $this->role_id, "last_login" => $this->last_login, "last_logout" => $this->last_logout));
        $query->andFilterWhere(array("like", "username", $this->username))->andFilterWhere(array("like", "password", $this->password))->andFilterWhere(array("like", "name", $this->name))->andFilterWhere(array("like", "photo_url", $this->photo_url));
        return $dataProvider;
    }
}

?>