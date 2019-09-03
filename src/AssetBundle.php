<?php
/**
 * @package yii2-fontawesome
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace rmrevin\yii\fontawesome;

/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * {@inheritDoc}
     */
    public $sourcePath = '@vendor/fortawesome/font-awesome-pro';

    /**
     * {@inheritDoc}
     */
    public $css = [
        'css/svg-with-js.min.css'
    ];

    /**
     * {@inheritDoc}
     */
    public $publishOptions = [
        'only' => [
            'css/*'
        ]
    ];

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        if (!is_dir($this->sourcePath)) {
            $this->sourcePath = '@vendor/fortawesome/font-awesome';
        }

        parent::init();
    }
}