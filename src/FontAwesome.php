<?php
/**
 * FontAwesome.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome;

/**
 * Class FA
 * @package rmrevin\yii\fontawesome
 */
abstract class FontAwesome
{
    /**
     * Size values
     * @see component\Icon::size
     */
    const SIZE_LARGE = 'lg';
    const SIZE_LG = 'lg';
    const SIZE_SMALL = 'sm';
    const SIZE_SM = 'sm';
    const SIZE_EXTRA_SMALL = 'xs';
    const SIZE_XS = 'xs';
    const SIZE_2X = '2x';
    const SIZE_3X = '3x';
    const SIZE_4X = '4x';
    const SIZE_5X = '5x';
    const SIZE_6X = '6x';
    const SIZE_7X = '7x';
    const SIZE_8X = '8x';
    const SIZE_9X = '9x';
    const SIZE_10X = '10x';

    /**
     * Rotate values
     * @see component\Icon::rotate
     */
    const ROTATE_90 = '90';
    const ROTATE_180 = '180';
    const ROTATE_270 = '270';

    /**
     * Flip values
     * @see component\Icon::flip
     */
    const FLIP_HORIZONTAL = 'horizontal';
    const FLIP_VERTICAL = 'vertical';


    /**
     * CSS class prefix
     * @var string
     */
    public static $cssPrefix;

    /**
     * Shortcut for `icon()` method
     *
     * @param string $name
     * @param array $options
     *
     * @return component\Icon
     * @see icon()
     *
     */
    public static function i(string $name, array $options = []): component\Icon
    {
        return static::icon($name, $options);
    }

    /**
     * Creates an `Icon` component that can be used to FontAwesome html icon
     *
     * @param string $name
     * @param array $options
     *
     * @return component\Icon
     */
    public static function icon(string $name, array $options = []): component\Icon
    {
        $icon = new component\Icon([
            'iconName' => $name,
            'options' => $options,
            'prefix' => static::$cssPrefix
        ]);
        AssetBundle::$iconStack[$name] = $icon;
        return $icon;
    }

    /**
     * Shortcut for `stack()` method
     *
     * @param array $options
     *
     * @return component\Stack
     * @see stack()
     *
     */
    public static function s(array $options = []): component\Stack
    {
        return static::stack($options);
    }

    /**
     * Creates an `Stack` component that can be used to FontAwesome html icon
     *
     * @param array $options
     *
     * @return component\Stack
     */
    public static function stack(array $options = []): component\Stack
    {
        return new component\Stack([
            'prefix' => static::$cssPrefix,
            'options' => $options
        ]);
    }
}
