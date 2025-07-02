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

        Yii::$app->view->on(Yii::$app->view::EVENT_END_BODY, function () {
            $icons = AssetBundle::$iconStack;
            if (empty($icons)) {
                return;
            }

            $html = '<svg style="display: none;">' . PHP_EOL;
            foreach ($icons as $icon) {
                $class = 'rmrevin\\yii\\fontawesome\\icons\\' . match ($icon->prefix) {
                    default => 'Solid',
                    'far' => 'Regular',
                    'fal' => 'Light',
                    'fab' => 'Brands',
                    'fat' => 'Thin',
                    'kit' => 'Custom'
                };
                $prefix = "{$icon->prefix}-";
                if ($icon->sharp) {
                    $prefix .= 's-';
                    $class .= 'Sharp';
                }
                if ($icon->duotone) {
                    $prefix .= 'd-';
                    $class .= 'Duotone';
                }
                $path = constant("$class::_" . strtoupper(str_replace('-', '_', $icon->iconName)));

                $content = is_array($path)
                    ? "<path class=\"fa-secondary\" opacity=\".4\" d=\"{$path[0]}\" />" . (empty($path[1])
                        ? ''
                        : "<path class=\"fa-primary\" d=\"{$path[1]}\" />"
                    )
                    :"<path fill=\"currentColor\" d=\"{$path}\"/>";
                $html .= "<symbol id=\"$prefix-{$icon->iconName}\">$content</symbol>" . PHP_EOL;
            }
            $html .= '</svg>' . PHP_EOL;
            echo $html;
        });
    }
}
