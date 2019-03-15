<?php

echo "\n<div class=\"master-slider ms-skin-default\" id=\"masterslider\">\n    <div class=\"ms-slide\">\n        <img src=\"";
echo yii\helpers\Url::to(array("css/blank.gif"));
echo "\" data-src=\"";
echo yii\helpers\Url::to(array("css/slider.png"));
echo "\" alt=\"lorem ipsum dolor sit\"/>\n    </div>\n    <div class=\"ms-slide\">\n        <img src=\"";
echo yii\helpers\Url::to(array("css/blank.gif"));
echo "\" data-src=\"";
echo yii\helpers\Url::to(array("css/slider.png"));
echo "\" alt=\"lorem ipsum dolor sit\"/>\n    </div>\n    <div class=\"ms-slide\">\n        <img src=\"";
echo yii\helpers\Url::to(array("css/blank.gif"));
echo "\" data-src=\"";
echo yii\helpers\Url::to(array("css/slider.png"));
echo "\" alt=\"lorem ipsum dolor sit\"/>\n    </div>\n</div>\n\n";
$this->registerJs("\n\nvar slider = new MasterSlider();\nslider.setup('masterslider' , {\n    width:800,\n    height:430,\n    fullwidth:true,\n    space:5,\n    view:\"basic\",\n    autoHeight:true\n});\nslider.control('arrows');\nslider.control('bullets' , {autohide:false});\nslider.control('scrollbar' , {dir:'h'});\n\n\n");

?>