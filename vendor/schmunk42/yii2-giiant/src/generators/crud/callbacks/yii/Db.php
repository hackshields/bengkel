<?php

/**
 * Created by PhpStorm.
 * User: tobias
 * Date: 09.06.15
 * Time: 23:26
 */
namespace schmunk42\giiant\generators\crud\callbacks\yii;

class Db
{
    public static function falseIfText()
    {
        // hide text columns (dbType: text)
        return function ($attribute, $model, $generator) {
            $column = $generator->getColumnByAttribute($attribute);
            if (!$column) {
                return null;
            }
            if ($column->dbType == 'text') {
                return false;
            }
        };
    }
    public static function falseIfAutoIncrement()
    {
        // hide AI columns
        return function ($attribute, $model, $generator) {
            $column = $generator->getColumnByAttribute($attribute);
            if (!$column) {
                return null;
            }
            if ($column->autoIncrement) {
                return false;
            }
        };
    }
}

?>