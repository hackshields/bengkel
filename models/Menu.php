<?php

namespace app\models;

class Menu extends base\Menu
{
    public function getIconNoPrefix()
    {
        return substr($this->icon, 3);
    }
}

?>