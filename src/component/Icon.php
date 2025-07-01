<?php
/**
 * Icon.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome\component;

use rmrevin\yii\fontawesome\AssetBundle;
use Yii;
use yii\base\Component;
use yii\helpers\Html;

/**
 * Class Icon
 * @package rmrevin\yii\fontawesome\component
 *
 * @property array $transform
 * @property static|null $mask
 * @property-read array $namespace
 */
class Icon extends Component
{
    /**
     * @var int a counter used to generate [[id]] for icons.
     * @internal
     */
    public static int $counter = 0;
    /**
     * @var string the prefix to the automatically generated icon IDs.
     * @see getId()
     */
    public static string $autoIdPrefix = 'fa';

    /**
     * @var string Style Prefix. One of fas, far, fal, fab, fat, fad or kit. Defaults to fas
     */
    public string $prefix = 'fas';

    /**
     * @var string Icon name
     */
    public string $iconName;

    /**
     * @var array the HTML attributes for the tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $options = [
        'class' => 'svg-inline--fa',
        'aria' => [
            'hidden' => 'true'
        ],
        'focusable' => 'false',
        'role' => 'img'
    ];

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = static::$autoIdPrefix . static::$counter++;
        }
        $this->options['data'] = [
            'prefix' => $this->prefix,
            'icon' => $this->iconName
        ];

        AssetBundle::register(Yii::$app->view);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString(): string
    {
        return Html::tag('svg', "<use xlink:href=\"#{$this->options['id']}\" />", $this->options) . PHP_EOL;
    }

    /**
     * @return static
     */
    public function fixedWidth(): Icon
    {
        Html::addCssClass($this->options, 'fa-fw');
        return $this;
    }
}
