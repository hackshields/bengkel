<?php

namespace app\models;

class Role extends base\Role
{
    const SUPER_ADMINISTRATOR = 1;
    const OWNER_BENGKEL = 2;
    const KEPALA_MEKANIK = 3;
    const KEPALA_BENGKEL = 4;
    const SERVICE_ADVISOR = 5;
    const MEKANIK = 6;
    const SPAREPART = 7;
    const KASIR = 8;
    const FRONT_DESK = 9;
    public function getRoleMenuColumn()
    {
        return \yii\helpers\Html::a("Set Menu", array("role/detail", "id" => $this->id), array("class" => "btn btn-primary"));
    }
}

?>