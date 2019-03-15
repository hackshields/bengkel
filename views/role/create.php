<?php

$this->title = "Tambah";
$this->params["breadcrumbs"][] = array("label" => "Hak Akses", "url" => array("index"));
$this->params["breadcrumbs"][] = $this->title;
echo "\n<div class=\"box box-info\">\n    <div class=\"box-body\">\n        ";
echo $this->render("_form", array("model" => $model));
echo "    </div>\n</div>";

?>