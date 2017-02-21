<?php

namespace xutl\alipay;

use xutl\aliplay\AliPlayAsset;
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

/**
 * Class AliPlayWidget
 * @package xutl\videojs
 */
class AliPlayWidget extends Widget
{
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->initOptions();
        $this->registerAssets();
    }

    /**
     * Initializes the widget options
     */
    protected function initOptions()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = 'video-' . $this->getId();
        }
        $this->clientOptions = array_merge(
            [
                'showBarTime' => 1000,
            ], $this->clientOptions);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $asset = AliPlayAsset::register($view);
        $view->registerJs('
        var player = new prismplayer({
        id: "J_prismPlayer",
        isLive: true,
        cover: "'.$stream->embedUrl.'",
        source: playUrls.flv,
        autoplay: false,      // 自动播放
        width: "750",       // 播放器宽度
        height: "422",      // 播放器高度
        showBarTime: 1000
    });
        
        videojs.options.flash.swf = "' . $asset->baseUrl . '/video-js.swf";');
        echo Html::beginTag('video', $this->options);

        echo Html::endTag('video');
        if (!empty($this->clientOptions)) {
            $clientOptions = Json::encode($this->clientOptions);

            $view->registerJs('var player = new prismplayer("#' . $this->options['id'] . '").ready(' . $clientOptions . ');');
        }
    }
}