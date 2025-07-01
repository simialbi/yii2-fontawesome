<?php
/**
 * @package yii2-fontawesome
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace rmrevin\yii\fontawesome;

use rmrevin\yii\fontawesome\component\Icon;
use Yii;

/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @var Icon[] Stack of used icon
     */
    public static array $iconStack = [];

    /**
     * {@inheritDoc}
     */
    public $sourcePath = '@bower/fontawesome';

    /**
     * {@inheritDoc}
     */
    public $css = [
        'css/svg-with-js.css'
    ];

    /**
     * {@inheritDoc}
     */
    public $publishOptions = [
        'only' => [
            'css/svg-with-js.css',
            'css/svg-with-js.min.css'
        ]
    ];

    /**
     * {@inheritDoc}
     */
    public function init(): void
    {
        parent::init();

        Yii::$app->view->on(Yii::$app->view::EVENT_BEGIN_BODY, function () {
            $icons = AssetBundle::$iconStack;
            if (empty($icons)) {
                return;
            }

            $html = '<svg xmlns="http://www.w3.org/2000/svg">' . PHP_EOL;
            foreach ($icons as $icon) {
                $class = 'rmrevin\\yii\\fontawesome\\icons\\' . match ($icon->prefix) {
                    default => 'Solid',
                    'far' => 'Regular',
                    'fal' => 'Light',
                    'fab' => 'Brands',
                    'fad' => 'Duotone',
                    'fat' => 'Thin',
                    'kit' => 'Custom'
                };
                $meta = constant("$class::_" . strtoupper(str_replace('-', '_', $icon->iconName)));
                $content = (is_array($meta[2]))
                    ? "<path class=\"fa-secondary\" opacity=\".4\" d=\"{$meta[2][0]}\" />" . (empty($meta[2][1])
                        ? ''
                        : "<path class=\"fa-primary\" d=\"{$meta[2][1]}\" />"
                    )
                    :"<path fill=\"currentColor\" d=\"{$meta[2]}\"/>";
                $html .= "<symbol id=\"{$icon->options['id']}\" viewBox=\"0 0 {$meta[0]} {$meta[1]}\">$content</symbol>" . PHP_EOL;
            }
            $html .= '</svg>' . PHP_EOL;
            echo $html;
        });
    }
}
