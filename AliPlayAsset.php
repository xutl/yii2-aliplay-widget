<?php
namespace xutl\aliplay;

use yii\web\View;

/**
 * Asset bundle for AliPlayAsset Widget
 */
class AliPlayAsset extends \yii\web\AssetBundle
{
    public $css = [
        '//g.alicdn.com/de/prismplayer/1.5.7/skins/default/index-min.css',
    ];

    public $js = [
        '//g.alicdn.com/de/prismplayer/1.5.7/prism-min.js',
    ];
}