<?php

$user = Yii::$app->user->identity;
$jaringan = $user->jaringan;
echo "<html>\n<head>\n    <style>\n        .judul {\n            font-size: 16px;\n        }\n    </style>\n</head>\n<body>\n<div class=\"judul\">";
echo $jaringan->nama;
echo "</div>\n<div class=\"judul\">";
echo $jaringan->alamat;
echo "</div>\n<div class=\"judul\">Telp : ";
echo $jaringan->no_telepon;
echo "</div>\n";
echo $content;
echo "</body>\n</html>";

?>