<?php
/**
 * @package yii2-fontawesome
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace rmrevin\yii\fontawesome;

use Yii;

/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * {@inheritDoc}
     */
    public $sourcePath = '@vendor/fortawesome/font-awesome';

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
        if (is_dir(Yii::getAlias('@vendor/fortawesome/font-awesome-pro'))) {
            $this->sourcePath = '@vendor/fortawesome/font-awesome-pro';
        }

        parent::init();
    }
}