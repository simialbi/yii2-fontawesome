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
    public $sourcePath = '@vendor/fontawesome/font-awesome';

    /**
     * {@inheritdoc}
     */
    public $css = [
        'css/svg-with-js.min.css'
    ];
}