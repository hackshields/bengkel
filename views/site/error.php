<?php

$this->title = $name;
echo "<!-- Main content -->\n<section class=\"content\">\n\n    <div class=\"error-page\">\n        <h2 class=\"headline text-info\"><i class=\"fa fa-warning text-yellow\"></i></h2>\n\n        <div class=\"error-content\">\n            <h3>";
echo $name;
echo "</h3>\n\n            <p>\n                ";
echo nl2br(yii\helpers\Html::encode($message));
echo "            </p>\n\n            <p>\n                The above error occurred while the Web server was processing your request.\n                Please contact us if you think this is a server error. Thank you.\n                Meanwhile, you may <a href='";
echo Yii::$app->homeUrl;
echo "'>return to dashboard</a> or try using the search\n                form.\n            </p>\n\n            <form class='search-form'>\n                <div class='input-group'>\n                    <input type=\"text\" name=\"search\" class='form-control' placeholder=\"Search\"/>\n\n                    <div class=\"input-group-btn\">\n                        <button type=\"submit\" name=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-search\"></i>\n                        </button>\n                    </div>\n                </div>\n            </form>\n        </div>\n    </div>\n\n</section>\n";

?>