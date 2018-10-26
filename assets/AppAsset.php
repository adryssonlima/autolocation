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

    public $jsOptions = array(
    	'position' => \yii\web\View::POS_HEAD
    );

    public $css = [
        'css/site.css',
	'css/style-wizard-circular.css',
	'font-awesome-4.7.0/css/font-awesome.min.css',
    ];
    public $js = [
    	'js/functions.js',
	'js/vue.min.js',
	'js/socket.io-1.4.5.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
	'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
