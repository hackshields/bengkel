<?php

$this->title = "Update Menu - " . $model->name;
$this->params["breadcrumbs"][] = array("label" => "Menu", "url" => array("index"));
$this->params["breadcrumbs"][] = array("label" => (string) $model->name, "url" => array("view", "id" => $model->id));
$this->params["breadcrumbs"][] = "Edit";
echo "<div class=\"box box-info\">\n    <div class=\"box-body\">\n        ";
echo $this->render("_form", array("model" => $model));
echo "    </div>\n</div>";

?>