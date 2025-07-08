<?php

namespace rmrevin\yii\fontawesome\component;

use rmrevin\yii\fontawesome\AssetBundle;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\helpers\Html;

/**
 * Layers are the new way to place icons and text visually on top of each other using the power of SVG+JS, replacing
 * classic icons stacks.
 * With this new approach, you can use more than two icons.
 *
 * @see https://fontawesome.com/docs/web/style/layer
 * @package rmrevin\yii\fontawesome\component
 */
class Layer extends BaseObject
{
    /**
     * @var array the HTML attributes for the tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $options = [];

    /**
     * @var array
     */
    private array $_elements = [];

    /**
     * Converts the FontAwesome layer representation to its string equivalent.
     *
     * @return string The string representation of the object.
     */
    public function __toString(): string
    {
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'span');

        Html::addCssClass($options, 'fa-layers');

        return Html::tag($tag, implode('', $this->_elements), $options);
    }

    /**
     * Adds an icon or text or counter to the icon stack.
     *
     * @param string|Icon $icon The icon object or text or counter to be added.
     * @param array $options Additional HTML tag options or attributes.
     * @param bool $prepend Set true to prepend icon instead of appending
     *
     * @return self
     */
    public function add(string|Icon $icon, array $options = [], bool $prepend = false): self
    {
        if (is_string($icon)) {
            $tag = ArrayHelper::remove($options, 'tag', 'span');
            if (!Html::hasCssClass($options, 'fa-layers-counter')) {
                Html::addCssClass($options, 'fa-layers-text');
            }
            $icon = Html::tag($tag, $icon, $options);
        } else {
            AssetBundle::$iconStack[$icon->prefix . '-' . $icon->iconName] = $icon;
        }
        if ($prepend) {
            array_unshift($this->_elements, $icon);
        } else {
            $this->_elements[] = $icon;
        }

        return $this;
    }

    /**
     * Adds a text element with the specified options to the current instance.
     *
     * @param string $text The text content to be added.
     * @param array $options An array of options to configure the text element.
     *
     * @return self
     * @deprecated Use add function
     * @see add
     */
    public function text(string $text, array $options): self
    {
        return $this->add($text, $options);
    }

    /**
     * Adds an icon to the current object.
     *
     * @param Icon $icon The icon to be added.
     *
     * @return self
     * @deprecated Use add function
     * @see add
     */
    public function icon(Icon $icon): self
    {
        return $this->add($icon);
    }

    /**
     * Adds a counter layer to the current object with the given text and options.
     *
     * @param string $text The text to be displayed in the counter.
     * @param array $options An array of options to configure the counter's appearance and behavior.
     *
     * @return self
     * @deprecated Use add function
     * @see add
     */
    public function counter(string $text, array $options): self
    {
        Html::addCssClass($options, 'fa-layers-counter');
        return $this->add($text, $options);
    }
}
