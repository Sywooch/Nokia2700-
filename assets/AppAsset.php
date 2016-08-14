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
    public $css = [
        'plugins/bootstrap/css/bootstrap-switch.min.css',
        'css/site.css',
        'css/jquery-ui.min.css',
        'css/AdminLTE.min.css',
        'css/blue.css',
        'css/_all-skins.min.css',
        'plugins/colorpicker/bootstrap-colorpicker.min.css',
        'css/analytics.css'
    ];
    public $js = [
        'plugins/jQuery/jquery-ui.min.js',
        'plugins/bootstrap/js/bootstrap.js',
        'js/fastclick.js',
        'js/demo.js',
        'js/app.min.js',
        //'js/modal.js',
        'js/Chart.min.js',
        'plugins/bootstrap/js/bootstrap-switch.min.js',
        'plugins/colorpicker/bootstrap-colorpicker.min.js',
        'plugins/helper.js',
        'js/jquery.inputmask.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
