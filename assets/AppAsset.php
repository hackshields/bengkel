<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\assets;

use yii\web\AssetBundle;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = ['https://fonts.googleapis.com/css?family=Open+Sans', 'css/style.css', 'css/themes/default/easyui.css', 'css/themes/icon.css', 'css/ribbon.css', 'css/ribbon-icon.css', '//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.1/jquery.jgrowl.min.css', 'css/famfamfam.css', 'css/minimal.css', 'css/emoji.css'];
    public $js = [
        'js/jquery.js',
        '//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.1/jquery.jgrowl.min.js',
        'js/jquery.easyui.min.js',
        'js/datagrid-filter.js',
        'js/jquery.ribbon.js',
        'js/jquery.mask.js',
        'js/accounting.min.js',
        //'js/datagrid-cellediting.js',
        'js/datagrid.search.js',
        'js/notify.js',
        //'js/socket.manager.js',
        'js/main.js',
        'js/realuploader-min.js',
        'js/syncmanager.js',
    ];
    public $depends = ['yii\\web\\YiiAsset'];
}

?>