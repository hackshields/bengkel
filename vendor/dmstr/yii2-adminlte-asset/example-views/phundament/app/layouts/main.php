<?php

use dmstr\widgets\Alert;
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */
$this->title = $this->title . ' [Backend] ' . Yii::$app->params['appName'];
dmstr\web\AdminLteAsset::register($this);
?>

<?php 
$this->beginPage();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php 
echo Html::csrfMetaTags();
?>
    <title><?php 
echo Html::encode($this->title);
?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Ionicons -->
    <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <?php 
$this->head();
?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition skin-black sidebar-mini">
<?php 
$this->beginBody();
?>

<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php 
echo \Yii::$app->homeUrl;
?>" class="logo"><?php 
echo getenv('APP_TITLE');
?></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php 
if (!\Yii::$app->user->isGuest) {
    ?>
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">1</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 1 notification(s)</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> Welcome to Phundament 4!
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-flag"></i>
                                <span class="label label-default"><?php 
    echo count(Yii::$app->urlManager->languages);
    ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Languages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php 
    foreach (Yii::$app->urlManager->languages as $language) {
        ?>
                                        <li>
                                            <?php 
        echo Html::a($language, ['', Yii::$app->urlManager->languageParam => $language]);
        ?>
                                        </li>
                                        <?php 
    }
    ?>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php 
    echo \Yii::$app->user->identity->username;
    ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <?php 
    echo \cebe\gravatar\Gravatar::widget(['email' => \Yii::$app->user->identity->profile->gravatar_email === null ? \Yii::$app->user->identity->email : \Yii::$app->user->identity->profile->gravatar_email, 'options' => ['alt' => \Yii::$app->user->identity->username], 'size' => 128]);
    ?>
                                    <p>
                                        <?php 
    echo \Yii::$app->user->identity->username;
    ?>
                                        <small><?php 
    echo \Yii::$app->user->identity->email;
    ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php 
    echo \yii\helpers\Url::to(['/user/settings/profile']);
    ?>"
                                           class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php 
    echo \yii\helpers\Url::to(['/user/security/logout']);
    ?>"
                                           class="btn btn-default btn-flat" data-method="post">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    <?php 
}
?>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <?php 
echo $this->render('_sidebar');
?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <small><?php 
echo $this->title;
?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->

        <section class="content">
            <?php 
echo Alert::widget();
?>
            <?php 
echo $content;
?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        Powered by <strong><a href="http://phundament.com">Phundament 4</a></strong>
    </footer>
</div>
<!-- ./wrapper -->

<?php 
$this->endBody();
?>
</body>
</html>
<?php 
$this->endPage();

?>