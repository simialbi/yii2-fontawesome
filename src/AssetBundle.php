<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome;

/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 * @deprecated use rmrevin\yii\fontawesome\CdnFreeAssetBundle
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $basePath = '@vendor/fortawesome/font-awesome';

    /**
     * {@inheritdoc}
     */
    public $css = [
        'svg-with-js/css/fa-svg-with-js.css'
    ];

    /**
     * {@inheritdoc}
     */
    public $publishOptions = [
        'only' => [
            'svg-with-js/css/*'
        ]
    ];
}
