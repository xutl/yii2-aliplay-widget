<?php

namespace xutl\aliplay;

use yii\web\View;
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\web\JsExpression;
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
    public $options = [
        'class' => 'prism-player',
    ];

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
        if (!isset ($this->clientOptions['source'])) {
            throw new InvalidConfigException ('The "clientOptions[source]" property must be set.');
        }
        $this->initOptions();
        $this->registerAssets();
    }

    /**
     * Initializes the widget options
     */
    protected function initOptions()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = 'video' . $this->getId();
        }
        $this->clientOptions = array_merge([
            'id' => $this->options['id'],
            //'showBarTime' => 1000,
            'autoplay' => true,
            'preload' => true,
        ], $this->clientOptions);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        AliPlayAsset::register($view);
        echo Html::tag('div', '', $this->options);
        if (!empty($this->clientOptions)) {
            if (is_array($this->clientOptions['source'])) {
                $source = "'" . Json::encode($this->clientOptions['source']) . "'";
                $this->clientOptions['source'] = "__SOURCE__";
            }
            $clientOptions = Json::encode($this->clientOptions);
            if (isset($source)) {
                $clientOptions = str_replace('"__SOURCE__"', $source, $clientOptions);
            }
            $view->registerJs("var {$this->options['id']} = new prismplayer({$clientOptions});");
        }
    }
}