<?php

namespace rmrevin\yii\fontawesome\component;

use rmrevin\yii\fontawesome\AssetBundle;
use rmrevin\yii\fontawesome\FontAwesome;
use rmrevin\yii\fontawesome\helpers\Html;
use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

/**
 * This class represents a FontAwesome icon component, offering various configurations,
 * including style prefixes, animations, transformations, and rendering as an SVG element.
 *
 * The Icon component adheres to the FontAwesome library's structure and conventions,
 * and integrates with Yii's rendering mechanisms for seamless inclusion in web applications.
 * It supports numerous customization options such as spinning, flipping, pulsing,
 * size adjustment, and alignment, allowing for dynamic and visually appealing icons.
 *
 * @property bool $sharp
 * @property bool $duotone
 * @property bool $isMask
 * @property-write bool $preventUse
 */
class Icon extends BaseObject
{
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

    /**
     * @var bool Indicates whether the icon should be displayed in sharp style.
     *  When enabled, 's-' will be added to the prefix.
     */
    private bool $_sharp = false;

    /**
     * @var bool Indicates whether the icon should be displayed in duotone style.
     *  When enabled, 'd-' will be added to the prefix.
     */
    private bool $_duotone = false;

    /**
     * @var bool Indicates whether the icon should be displayed with inverted color.
     *  When enabled, the CSS class 'fa-inverse' will be added.
     */
    private bool $_inverse = false;

    /**
     * @var bool Indicates whether the icon should perform a 360° rotation clockwise.
     *  When enabled, the CSS class 'fa-spin' will be added.
     * @see https://docs.fontawesome.com/web/style/animate
     */
    private bool $_spin = false;

    /**
     * @var bool Indicates whether the icon should perform a 360° rotation clockwise in 8 incremental steps.
     *  When enabled, the CSS class 'fa-pulse' will be added.
     * @see https://docs.fontawesome.com/web/style/animate
     */
    private bool $_pulse = false;

    /**
     * @var bool Indicates whether the rotation of the icon should be in reverse direction (counter-clockwise).
     *  Used in combination with $_spin or $_pulse and adds the CSS class 'fa-spin-reverse'.
     */
    private bool $_reverse = false;

    /**
     * @var bool Indicates whether the icon should be animated with a pulsing heartbeat effect.
     *  When enabled, the CSS class 'fa-beat' will be added.
     * @see https://docs.fontawesome.com/web/style/animate
     */
    private bool $_beat = false;

    /**
     * @var bool Indicates whether the icon should be animated with a fade in/out effect.
     *  When enabled, the CSS class 'fa-fade' will be added.
     * @see https://docs.fontawesome.com/web/style/animate
     */
    private bool $_fade = false;

    /**
     * @var bool Indicates whether the icon should be animated with a shaking effect.
     *  When enabled, the CSS class 'fa-shake' will be added.
     * @see https://docs.fontawesome.com/web/style/animate
     */
    private bool $_shake = false;
    /**
     * @var bool Indicates whether the icon should be animated with a bouncing effect.
     *  When enabled, the CSS class 'fa-bounce' will be added.
     * @see https://docs.fontawesome.com/web/style/animate
     */
    private bool $_bounce = false;
    /**
     * @var bool Indicates whether the icon should be displayed with a fixed width.
     *  When enabled, the CSS class 'fa-fw' will be added.
     * @see https://docs.fontawesome.com/web/style/fixed-width
     */
    private bool $_fixedWidth = false;
    /**
     * @var bool Indicates whether the icon should be displayed with a border.
     *  When enabled, the CSS class 'fa-border' will be added.
     * @see https://docs.fontawesome.com/web/style/border
     */
    private bool $_border = false;
    /**
     * @var bool Indicates whether the icon should be aligned to the left.
     *  When enabled, the CSS class 'fa-pull-left' will be added.
     * @see https://docs.fontawesome.com/web/style/pull-left-right
     */
    private bool $_pullLeft = false;
    /**
     * @var bool Indicates whether the icon should be aligned to the right.
     *  When enabled, the CSS class 'fa-pull-right' will be added.
     * @see https://docs.fontawesome.com/web/style/pull-left-right
     */
    private bool $_pullRight = false;
    /**
     * @var string Specifies the direction in which the icon should be flipped.
     *  Valid values are defined in FontAwesome::FLIP.
     *  When set, the CSS class 'fa-flip-{$_flip}' will be added.
     * @see https://docs.fontawesome.com/web/style/flip
     */
    private string $_flip;
    /**
     * @var string Specifies the size of the icon.
     *  Valid values are defined in FontAwesome::SIZE.
     *  When set, the CSS class 'fa-{$_size}' will be added.
     * @see https://docs.fontawesome.com/web/style/size
     */
    private string $_size;
    /**
     * @var int Specifies the rotation degree of the icon in degrees.
     *  When set, either 'fa-rotate-{$_rotate}' for predefined rotations
     *  or 'fa-rotate-by' with a custom degree will be added.
     * @see https://docs.fontawesome.com/web/style/rotate
     */
    private int $_rotate;
    /**
     * @var array Contains transformation instructions for the icon.
     *  Transformations may include scaling, shifting, and flipping.
     *  Valid transformation types are defined in FontAwesome::TRANSFORM.
     * @see https://docs.fontawesome.com/web/style/power-transform
     */
    private array $_transform;

    /**
     * @var self The representation of the mask background icon of this icon.
     * @see https://docs.fontawesome.com/web/style/mask
     */
    private self $_mask;

    /**
     * @var bool Indicates whether this icon represents a mask or not.
     */
    private bool $_isMask = false;

    /**
     * @var bool Whether to prevent use method and force full rendering
     */
    private bool $_preventUse = false;

    /**
     * {@inheritDoc}
     */
    public function init(): void
    {
        parent::init();

        $this->iconName = trim($this->iconName);

        AssetBundle::register(Yii::$app->view);
    }

    /**
     * Converts the FontAwesome icon representation to its string equivalent as an SVG element.
     *
     * This method generates an SVG representation of the icon with various optional transformations,
     * styles, and configurations applied. It uses the icon's prefix, name, and additional properties
     * to dynamically construct the SVG with appropriate attributes and classes.
     *
     * @return string The rendered SVG representation of the FontAwesome icon.
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
        if ($this->_inverse) {
            Html::addCssClass($options, 'fa-inverse');
        }
        if ($this->_spin) {
            Html::addCssClass($options, 'fa-spin');
        }
        if ($this->_pulse) {
            Html::addCssClass($options, 'fa-pulse');
        }
        if ($this->_reverse && ($this->_spin || $this->_pulse)) {
            Html::addCssClass($options, 'fa-spin-reverse');
        }
        if ($this->_beat && $this->_fade) {
            Html::addCssClass($options, 'fa-beat-fade');
        } elseif ($this->_beat) {
            Html::addCssClass($options, 'fa-beat');
        } elseif ($this->_fade) {
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
        if (isset($this->_mask)) {
            $mask = ($this->_mask->prefix === 'kit' ? '_K' : '') . '_' . strtoupper(str_replace('-', '_', $this->_mask->iconName));
            $mask = constant("rmrevin\yii\\fontawesome\icons\Sizes::$mask");
            $transform = FontAwesome::transformForSvg($this->_transform ?? [], $mask[0], $icon[0]);
            $id = uniqid();
            $clipPath = FontAwesome::renderIconPath($this->_mask, false);

            return Html::tag('svg', "<defs><clipPath id=\"clip-$id\">$clipPath</clipPath><mask x=\"0\" y=\"0\" height=\"100%\" width=\"100%\" id=\"mask-$id\" maskUnits=\"userSpaceOnUse\" maskContentUnits=\"userSpaceOnUse\"><rect x=\"0\" y=\"0\" width=\"100%\" height=\"100%\" fill=\"white\" /><g transform=\"{$transform['outer']}\"><g transform=\"{$transform['inner']}\"><use href=\"#$prefix-{$this->iconName}\" fill=\"black\" transform=\"{$transform['path']}\" /></g></g></mask></defs><rect fill=\"currentColor\" clip-path=\"url(#clip-$id)\" mask=\"url(#mask-$id)\" x=\"0\" y=\"0\" width=\"100%\" height=\"100%\" />", $options);
        }
        if (isset($this->_transform)) {
            $transform = FontAwesome::transformForSvg($this->_transform, $icon[0], $icon[0]);
            return Html::tag(
                'svg',
                "<g transform=\"{$transform['outer']}\"><g transform=\"{$transform['inner']}\"><use href=\"#$prefix-{$this->iconName}\" transform=\"{$transform['path']}\" /></g></g>",
                $options
            );
        }

        $content = $this->_preventUse
            ? FontAwesome::renderIconPath($this, false)
            : "<use href=\"#$prefix-{$this->iconName}\" />";

        return Html::tag('svg', $content, $options);
    }

    /**
     * Retrieves the sharp status of the icon.
     *
     * This method checks whether the sharp style is applied to the icon and returns its current state.
     *
     * @return bool True if the sharp style is applied, false otherwise.
     */
    public function getSharp(): bool
    {
        return $this->_sharp;
    }

    /**
     * Sets the sharp property for the icon representation.
     *
     * This method allows enabling or disabling the sharp variant of the icon.
     *
     * @param bool $sharp Determines whether the sharp variant of the icon should be enabled. Defaults to true.
     *
     * @return self The current instance for method chaining.
     */
    public function setSharp(bool $sharp = true): self
    {
        $this->_sharp = $sharp;
        return $this;
    }

    /**
     * Sets the sharp style for the FontAwesome icon.
     *
     * This method applies the "sharp" style to the icon by configuring the relevant property
     * and prepares the icon for rendering with sharp edges.
     *
     * @return self The current instance of the object for method chaining.
     */
    public function sharp(): self
    {
        return $this->setSharp();
    }

    /**
     * Retrieves the duotone state of the FontAwesome icon.
     *
     * This method indicates whether the icon is configured as a duotone icon.
     *
     * @return bool True if the icon is set as duotone, false otherwise.
     */
    public function getDuotone(): bool
    {
        return $this->_duotone;
    }

    /**
     * Sets the duotone mode for the icon.
     *
     * This method allows enabling or disabling the duotone style for the icon.
     * Duotone mode applies a two-tone color scheme to the icon if supported.
     *
     * @param bool $duotone Whether to enable duotone mode. Defaults to true.
     *
     * @return self The current instance with the updated duotone setting.
     */
    public function setDuotone(bool $duotone = true): self
    {
        $this->_duotone = $duotone;
        return $this;
    }

    /**
     * Sets the icon style to duotone.
     *
     * This method configures the icon to use the duotone variant, applying specific
     * styling or functionality associated with this mode.
     *
     * @return self The current instance with the duotone style applied.
     */
    public function duotone(): self
    {
        return $this->setDuotone();
    }

    /**
     * Enables the prevention of usage of use tag.
     *
     * This method sets an internal flag to prevent the use of a the use tag and renders full icon.
     *
     * @return self The instance of the class with the updated prevention flag for method chaining.
     */
    public function setPreventUse(): self
    {
        $this->_preventUse = true;
        return $this;
    }

    /**
     * Enables the inverse style for the FontAwesome icon.
     *
     * This method sets the inverse property to true, which applies the inverse style to the icon's appearance.
     *
     * @return self The instance of the class with the inverse style enabled for method chaining.
     */
    public function inverse(): self
    {
        $this->_inverse = true;
        return $this;
    }

    /**
     * Enables the spinning animation for the icon.
     *
     * This method sets the internal spin property to true, allowing the icon to be rendered with a
     * spinning effect when converted to its final representation.
     *
     * @return self The instance of the current object with the spinning effect enabled.
     */
    public function spin(): self
    {
        $this->_spin = true;
        return $this;
    }

    /**
     * Enables the "pulse" effect for the FontAwesome icon.
     *
     * This method sets the internal flag to apply the "pulse" animation effect to the icon,
     * causing it to oscillate as part of its visual representation.
     *
     * @return self The current instance with the "pulse" effect enabled.
     */
    public function pulse(): self
    {
        $this->_pulse = true;
        return $this;
    }

    /**
     * Enables the reverse mode for the current icon instance.
     *
     * This method sets the reverse mode, used in combination with pulse or spin to reverse the animation
     *
     * @return self The current instance with the reverse mode applied.
     */
    public function reverse(): self
    {
        $this->_reverse = true;
        return $this;
    }

    /**
     * Enables the "beat" animation for the FontAwesome icon.
     *
     * When this method is called, the "beat" CSS class is applied to the icon,
     * creating a pulsating animation effect. This method sets the beat property
     * to true and returns the current instance to allow method chaining.
     *
     * @return self The instance with the "beat" animation enabled.
     */
    public function beat(): self
    {
        $this->_beat = true;
        return $this;
    }

    /**
     * Enables the fade effect for the FontAwesome icon.
     *
     * This method sets the fade property, allowing the icon to be rendered with a fade effect,
     * altering its appearance to include a smooth fading transition.
     *
     * @return self The current instance with the fade effect applied.
     */
    public function fade(): self
    {
        $this->_fade = true;
        return $this;
    }

    /**
     * Enables the shake effect for the FontAwesome icon.
     *
     * This method activates the shake animation by setting the relevant property
     * indicating that the shake effect should be applied to the icon. The instance
     * is returned for method chaining.
     *
     * @return self The current instance with the shake effect enabled.
     */
    public function shake(): self
    {
        $this->_shake = true;
        return $this;
    }

    /**
     * Enables the bounce effect for the FontAwesome icon.
     *
     * This method allows the icon to have a bouncing animation by setting the internal `_bounce` property
     * to true and returns the current instance for method chaining.
     *
     * @return self The current instance with the bounce effect enabled.
     */
    public function bounce(): self
    {
        $this->_bounce = true;
        return $this;
    }

    /**
     * Enables the fixed width style for the icon.
     *
     * This method applies the `fa-fw` class to the icon, ensuring it has a fixed width.
     * Fixed width icons are useful for aligning icons with text or other elements in a consistent way,
     * especially in lists or other structured layouts.
     *
     * @return self The current instance with the fixed width style applied.
     */
    public function fixedWidth(): self
    {
        $this->_fixedWidth = true;
        return $this;
    }

    /**
     * This is a shortcut for the fixedWidth method.
     *
     * @return self The current instance with the fixed width style applied.
     * @see fixedWidth
     */
    public function fw(): self
    {
        return $this->fixedWidth();
    }

    /**
     * Enables the border style for the FontAwesome icon.
     *
     * This method applies a border effect to the icon by setting the internal border property.
     * It modifies the icon's styling to display with a border when rendered.
     *
     * @return self The current instance with the border style enabled.
     */
    public function border(): self
    {
        $this->_border = true;
        return $this;
    }

    /**
     * Enables the "pull left" styling for the current instance.
     *
     * This method applies the "pull left" configuration, typically causing the element
     * to be styled or positioned to the left. The method can be chained with other configurations.
     *
     * @return self The current instance with the "pull left" styling applied.
     */
    public function pullLeft(): self
    {
        $this->_pullLeft = true;
        return $this;
    }

    /**
     * Enables the "pull right" alignment for the element.
     *
     * This method sets the element's alignment to pull right by modifying its internal state.
     * Allows chaining for fluent interface usage.
     *
     * @return self The instance of the class with the "pull right" alignment applied.
     */
    public function pullRight(): self
    {
        $this->_pullRight = true;
        return $this;
    }

    /**
     * Sets the flip transformation for the FontAwesome icon.
     *
     * This method allows applying a flip transformation (e.g., horizontal, vertical, or both)
     * to the FontAwesome icon. If the provided flip value is valid, it is stored for use
     * in rendering the icon.
     *
     * @param string $flip The flip transformation to apply. Accepted values are predefined constants in
     *     FontAwesome::FLIP.
     *
     * @return self The current instance with the flip transformation applied.
     */
    public function flip(string $flip): self
    {
        if (in_array($flip, FontAwesome::FLIP)) {
            $this->_flip = $flip;
        }
        return $this;
    }

    /**
     * Sets the size of the FontAwesome icon.
     *
     * This method allows setting the size of the icon to one of the predefined sizes in the FontAwesome size constants.
     * If the provided size is valid, it updates the internal size property.
     *
     * @param string $size The size value to set for the icon. Must be one of the FontAwesome size constants.
     *
     * @return self The instance of the class with the updated size property for method chaining.
     */
    public function size(string $size): self
    {
        if (in_array($size, FontAwesome::SIZE)) {
            $this->_size = $size;
        }
        return $this;
    }

    /**
     * Rotates the current instance by the specified degree.
     *
     * This method sets the rotation angle for the instance and returns itself
     * for method chaining.
     *
     * @param int $degree The degree by which the instance should be rotated. Defaults to 90.
     *
     * @return self The current instance with the updated rotation degree.
     */
    public function rotate(int $degree = 90): self
    {
        $this->_rotate = $degree;
        return $this;
    }

    /**
     * Applies transformations to the current FontAwesome icon configuration.
     *
     * This method processes a set of transformation instructions, validates them against
     * predefined transformation types, and applies the valid transformations to the icon.
     * It updates the internal state with the processed transformations.
     *
     * @param array $transform The list of transformations to be applied. Each transformation is
     *                          passed as a key-value pair or as a string in the format 'transformation-value'.
     *                          Valid transformations include predefined constants from FontAwesome::TRANSFORM.
     *
     * @return self The current instance with the transformations applied.
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

    /**
     * Sets a mask for the current object.
     *
     * This method assigns a given mask to the object and allows for method chaining.
     *
     * @param self $mask The mask object to be assigned.
     *
     * @return static The current instance with the mask applied.
     */
    public function mask(self $mask): static
    {
        $mask->isMask = true;
        $this->_mask = $mask;
        return $this;
    }

    /**
     * Retrieves the mask status of the object.
     *
     * This method returns the current mask state, which indicates whether the object is treated as a mask.
     *
     * @return bool The mask status of the object.
     */
    public function getIsMask(): bool
    {
        return $this->_isMask;
    }

    /**
     * Sets whether the object should be treated as a mask.
     *
     * This method updates the internal property to indicate whether the object should act as a mask.
     *
     * @param bool $isMask A boolean value indicating if the object should be treated as a mask.
     *
     * @return void
     */
    public function setIsMask(bool $isMask): void
    {
        $this->_isMask = $isMask;
    }
}
