<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

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
        //'css/site.css',
        'css/common.css',
        'css/simplePagination.css',
        'css/dialog/dialog_box.css',
        'css/datepicker/jquery-ui.css',
        'css/custom.css',
    ];
    public $js = [
        'js/modernizr.js',
        'js/jquery.min.js',
        'js/dialog/dialog_box.js',
        'js/dialog/set_dialog.js',
        'js/jquery-ui.js',
        'js/common.js',
        'js/main.js',
        'js/form.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
