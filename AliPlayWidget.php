<?php

namespace xutl\aliplay;

use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\Html;

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
        AliPlayAsset::register($view);
        echo Html::tag('div', $this->options);
        if (!empty($this->clientOptions)) {
            $clientOptions = Json::encode($this->clientOptions);
            $view->registerJs("var {$this->options['id']} = new prismplayer({$clientOptions})");
        }
    }
}