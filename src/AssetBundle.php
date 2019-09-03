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
     * {@inheritdoc}
     */
    public $sourcePath = '@vendor/fortawesome/font-awesome-pro';

    /**
     * {@inheritdoc}
     */
    public $css = [
        'css/svg-with-js.min.css'
    ];

    /**
     * {@inheritdoc}
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