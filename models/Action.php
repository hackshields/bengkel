<?php

namespace app\models;

class Action extends base\Action
{
    public static function getAccess($controllerId)
    {
        $rules = array();
        if ($controllerId == "site") {
            $rules[] = array("actions" => array("login", "register", "error", "logout"), "allow" => true);
        }
        if (\Yii::$app->user->identity != NULL) {
            $allowed = Action::getAllowedAction($controllerId, \Yii::$app->user->identity->role_id);
            if (count($allowed) != 0) {
                $rules[] = array("actions" => $allowed, "allow" => true, "roles" => array("@"));
            }
        }
        $rules[] = array("allow" => false);
        if (\Yii::$app->user->identity->role_id == Role::SUPER_ADMINISTRATOR) {
            $rules = array(array("allow" => true));
        }
        return array("as beforeRequest" => array("class" => "yii\\filters\\AccessControl", "rules" => $rules));
    }
    public static function getAllowedAction($controllerId, $role_id)
    {
        $output = array();
        foreach (Action::find()->where(array("controller_id" => $controllerId))->all() as $action) {
            if ($role_id == 1) {
                $output[] = $action->action_id;
            } else {
                $roleAction = RoleAction::find()->where(array("action_id" => $action->id, "role_id" => $role_id))->one();
                if ($roleAction) {
                    $output[] = $action->action_id;
                }
            }
        }
        return $output;
    }
}

?>