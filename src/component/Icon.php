<?php
/**
 * Icon.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome\component;

use rmrevin\yii\fontawesome\AssetBundle;
use rmrevin\yii\fontawesome\FontAwesome;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Icon
 * @package rmrevin\yii\fontawesome\component
 *
 * @property array $transform
 * @property bool $sharp
 * @property bool $duotone
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
    public array $options = [];

    private bool $_sharp = false;

    private bool $_duotone = false;

    private bool $_spin = false;

    private bool $_pulse = false;

    private bool $_reverse = false;

    private bool $_beat = false;

    private bool $_fade = false;

    private bool $_shake = false;

    private bool $_bounce = false;

    private bool $_fixedWidth = false;

    private bool $_border = false;

    private bool $_pullLeft = false;

    private bool $_pullRight = false;

    private string $_flip;

    private string $_size;

    private int $_rotate;

    private array $_transform;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = static::$autoIdPrefix . static::$counter++;
        }

        AssetBundle::register(Yii::$app->view);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString(): string
    {
        $icon = ($this->prefix === 'kit' ? '_K' : '') . '_' . strtoupper(str_replace('-', '_', $this->iconName));
        $icon = constant("rmrevin\yii\\fontawesome\icons\Sizes::$icon");
        $options = ArrayHelper::merge([
            'aria' => [
                'hidden' => 'true'
            ],
            'focusable' => 'false',
            'role' => 'img',
            'data' => [
                'prefix' => $this->prefix,
                'icon' => $this->iconName
            ],
            'viewBox' => '0 0 ' . implode(' ', $icon)
        ], $this->options);

        $prefix = "{$this->prefix}-";
        if ($this->_duotone) {
            $prefix .= 'd-';
        }
        if ($this->_sharp) {
            $prefix .= 's-';
        }

        Html::addCssClass($options, ['svg-inline--fa', "fa-{$this->iconName}"]);
        if ($this->_spin) {
            Html::addCssClass($options, 'fa-spin');
        }
        if ($this->_pulse) {
            Html::addCssClass($options, 'fa-pulse');
        }
        if ($this->_reverse && ($this->_spin || $this->_pulse)) {
            Html::addCssClass($options, 'fa-spin-reverse');
        }
        if ($this->_beat) {
            Html::addCssClass($options, 'fa-beat');
        }
        if ($this->_fade) {
            Html::addCssClass($options, 'fa-fade');
        }
        if ($this->_shake) {
            Html::addCssClass($options, 'fa-shake');
        }
        if ($this->_bounce) {
            Html::addCssClass($options, 'fa-bounce');
        }
        if ($this->_fixedWidth) {
            Html::addCssClass($options, 'fa-fw');
        }
        if ($this->_border) {
            Html::addCssClass($options, 'fa-border');
        }
        if ($this->_pullLeft) {
            Html::addCssClass($options, 'fa-pull-left');
        }
        if ($this->_pullRight) {
            Html::addCssClass($options, 'fa-pull-right');
        }
        if (isset($this->_flip)) {
            Html::addCssClass($options, 'fa-flip-' . $this->_flip);
        }
        if (isset($this->_size)) {
            Html::addCssClass($options, 'fa-' . $this->_size);
        }
        if (isset($this->_rotate)) {
            if (in_array($this->_rotate, FontAwesome::ROTATE, true)) {
                Html::addCssClass($options, 'fa-rotate-' . $this->_rotate);
            } else {
                Html::addCssClass($options, 'fa-rotate-by');
                Html::addCssStyle($options, ['--fa-rotate-angle' => $this->_rotate . 'deg']);
            }
        }
        if (isset($this->_transform)) {
            $transform = FontAwesome::transformForSvg($this->_transform, $icon[0], $icon[0]);
            return Html::tag(
                'svg',
                "<g transform=\"{$transform['outer']}\"><g transform=\"{$transform['inner']}\"><use xlink:href=\"#$prefix-{$this->iconName}\" transform=\"{$transform['path']}\" /></g></g>",
                $options
            ) . PHP_EOL;
        }

        return Html::tag('svg', "<use xlink:href=\"#$prefix-{$this->iconName}\" />", $options) . PHP_EOL;
    }

    public function getSharp(): bool
    {
        return $this->_sharp;
    }

    public function setSharp(bool $sharp = true): self
    {
        $this->_sharp = $sharp;
        return $this;
    }

    public function sharp(): self
    {
        return $this->setSharp();
    }

    public function getDuotone(): bool
    {
        return $this->_duotone;
    }

    public function setDuotone(bool $duotone = true): self
    {
        $this->_duotone = $duotone;
        return $this;
    }

    public function duotone(): self
    {
        return $this->setDuotone();
    }

    /**
     * Makes an icon spin 360° clock-wise
     *
     * @return self
     * @see https://docs.fontawesome.com/web/style/animate
     * @see https://docs.fontawesome.com/web/style/style-cheatsheet
     */
    public function spin(): self
    {
        $this->_spin = true;
        return $this;
    }

    /**
     * @return self
     */
    public function reverse(): self
    {
        $this->_reverse = true;
        return $this;
    }

    /**
     * Makes an icon spin 360° clock-wise in 8 incremental steps
     *
     * @return self
     * @see https://docs.fontawesome.com/web/style/animate
     * @see https://docs.fontawesome.com/web/style/style-cheatsheet
     */
    public function pulse(): self
    {
        $this->_pulse = true;
        return $this;
    }

    /**
     * @return self
     */
    public function beat(): self
    {
        $this->_beat = true;
        return $this;
    }

    /**
     * @return self
     */
    public function fade(): self
    {
        $this->_fade = true;
        return $this;
    }

    /**
     * @return self
     */
    public function shake(): self
    {
        $this->_shake = true;
        return $this;
    }

    /**
     * @return self
     */
    public function bounce(): self
    {
        $this->_bounce = true;
        return $this;
    }

    /**
     * @return self
     */
    public function fixedWidth(): self
    {
        $this->_fixedWidth = true;
        return $this;
    }

    /**
     * @return self
     */
    public function border(): self
    {
        $this->_border = true;
        return $this;
    }

    /**
     * @return self
     */
    public function pullLeft(): self
    {
        $this->_pullLeft = true;
        return $this;
    }

    /**
     * @return self
     */
    public function pullRight(): self
    {
        $this->_pullRight = true;
        return $this;
    }

    /**
     * @param string $flip
     *
     * @return self
     */
    public function flip(string $flip): self
    {
        if (in_array($flip, FontAwesome::FLIP)) {
            $this->_flip = $flip;
        }
        return $this;
    }

    /**
     *
     * @param string $size
     *
     * @return self
     */
    public function size(string $size): self
    {
        if (in_array($size, FontAwesome::SIZE)) {
            $this->_size = $size;
        }
        return $this;
    }

    /**
     * @param int $degree
     *
     * @return self
     */
    public function rotate(int $degree = 90): self
    {
        $this->_rotate = $degree;
        return $this;
    }

    /**
     * @param array $transform
     *
     * @return self
     */
    public function transform(array $transform): self
    {
        $set = [];
        foreach ($transform as $transformation => $value) {
            if (is_int($transformation)) {
                [$transformation, $value] = explode('-', $value);
            }
            if (in_array($transformation, FontAwesome::TRANSFORM)) {
                if (in_array($transformation, [FontAwesome::TRANSFORM_FLIP_H, FontAwesome::TRANSFORM_FLIP_V])) {
                    $set[$transformation] = true;
                    continue;
                }
                $set[$transformation] = (int)$value;
            }
        }
        $this->_transform = $set;
        return $this;
    }
}
