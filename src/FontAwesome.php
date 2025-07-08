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
    const SIZE = [
        self::SIZE_LG,
        self::SIZE_SM,
        self::SIZE_XS,
        self::SIZE_2X,
        self::SIZE_3X,
        self::SIZE_4X,
        self::SIZE_5X,
        self::SIZE_6X,
        self::SIZE_7X,
        self::SIZE_8X,
        self::SIZE_9X,
        self::SIZE_10X
    ];
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
    const ROTATE = [self::ROTATE_90, self::ROTATE_180, self::ROTATE_270];
    const ROTATE_90 = 90;
    const ROTATE_180 = 180;
    const ROTATE_270 = 270;

    /**
     * Flip values
     * @see component\Icon::flip
     */
    const FLIP = [self::FLIP_HORIZONTAL, self::FLIP_VERTICAL, self::FLIP_BOTH];
    const FLIP_HORIZONTAL = 'horizontal';
    const FLIP_VERTICAL = 'vertical';
    const FLIP_BOTH = 'both';

    /**
     * Transform values
     * @see component\Icon::transform
     */
    const TRANSFORM = [
        self::TRANSFORM_GROW,
        self::TRANSFORM_SHRINK,
        self::TRANSFORM_UP,
        self::TRANSFORM_DOWN,
        self::TRANSFORM_LEFT,
        self::TRANSFORM_RIGHT,
        self::TRANSFORM_ROTATE,
        self::TRANSFORM_FLIP_H,
        self::TRANSFORM_FLIP_V
    ];
    const TRANSFORM_GROW = 'grow';
    const TRANSFORM_SHRINK = 'shrink';
    const TRANSFORM_UP = 'up';
    const TRANSFORM_DOWN = 'down';
    const TRANSFORM_LEFT = 'left';
    const TRANSFORM_RIGHT = 'right';
    const TRANSFORM_ROTATE = 'rotate';
    const TRANSFORM_FLIP_H = 'flip-h';
    const TRANSFORM_FLIP_HORIZONTAL = self::TRANSFORM_FLIP_H;
    const TRANSFORM_FLIP_V = 'flip-v';
    const TRANSFORM_FLIP_VERTICAL = self::TRANSFORM_FLIP_V;


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
        AssetBundle::$iconStack[static::$cssPrefix . '-' . $name] = $icon;
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
            'options' => $options
        ]);
    }

    public static function l(array $options = []): component\Layer
    {
        return self::layer($options);
    }

    public static function layer(array $options = []): component\Layer
    {
        return new component\Layer(['options' => $options]);
    }

    /**
     * Transforms a set of parameters into an SVG-compatible transformation array.
     *
     * @param array $transform An associative array containing transformation attributes as defined in `TRANSFORM_` constants.
     * @param int $containerWidth The width of the container for the SVG.
     * @param int $iconWidth The width of the icon.
     *
     * @return array An array of transformed strings for SVG rendering, including attributes for outer, inner, and path transformations.
     */
    public static function transformForSvg(array $transform, int $containerWidth, int $iconWidth): array
    {
        $transform = self::getMeaningfulTransform($transform);
        return [
            'outer' => 'translate(' . ($containerWidth / 2) . ' 256)',
            'inner' => implode(' ', [
                'translate(' . ($transform['x'] * 32) . ', ' . ($transform['y'] * 32) . ')',
                'scale(' . ($transform['size'] / 16 * ($transform['flipX'] ? -1 : 1)) . ', ' . ($transform['size'] / 16 * ($transform['flipY'] ? -1 : 1)) . ')',
                'rotate(' . $transform['rotate'] . ' 0 0)'
            ]),
            'path' => 'translate(' . ($iconWidth / -2) . ' -256)'
        ];
    }

    /**
     * Processes a set of transformation instructions and generates a meaningful representation
     * of the transformations to be applied based on predefined constants and rules.
     *
     * @param array $transform An associative array of transformation keys and their corresponding values.
     *                          The keys represent transformation types such as flipping, resizing, or moving,
     *                          and their values specify the magnitude or direction of the transformation.
     *
     * @return array An associative array of structured transformation data containing:
     *               - 'flipX' (bool): Indicates whether to flip horizontally.
     *               - 'flipY' (bool): Indicates whether to flip vertically.
     *               - 'size' (int): Adjusted size value factoring growth or shrinkage.
     *               - 'x' (int): Horizontal displacement value.
     *               - 'y' (int): Vertical displacement value.
     *               - 'rotate' (int): Rotation angle applied.
     */
    protected static function getMeaningfulTransform(array $transform): array
    {
        $result = [
            'flipX' => false,
            'flipY' => false,
            'size' => 16,
            'x' => 0,
            'y' => 0,
            'rotate' => 0
        ];
        foreach ($transform as $key => $value) {
            if ($key === self::TRANSFORM_FLIP_HORIZONTAL) {
                $result['flipX'] = true;
                continue;
            }
            if ($key === self::TRANSFORM_FLIP_VERTICAL) {
                $result['flipY'] = true;
                continue;
            }
            switch ($key) {
                case self::TRANSFORM_GROW:
                    $result['size'] = 16 + $value;
                    continue 2;
                case self::TRANSFORM_SHRINK:
                    $result['size'] = 16 - $value;
                    continue 2;
                case self::TRANSFORM_LEFT:
                    $result['x'] = 0 - $value;
                    continue 2;
                case self::TRANSFORM_RIGHT:
                    $result['x'] = 0 + $value;
                    continue 2;
                case self::TRANSFORM_UP:
                    $result['y'] = 0 - $value;
                    continue 2;
                case self::TRANSFORM_DOWN:
                    $result['y'] = 0 + $value;
                    continue 2;
                case self::TRANSFORM_ROTATE:
                    $result['rotate'] = 0 + $value;
                    continue 2;
            }
        }

        return $result;
    }

    /**
     * Generates the SVG path or symbol for a given icon based on its properties,
     * such as prefix, style (regular, solid, light, etc.), and optional features
     * like sharp or duotone styles.
     *
     * @param component\Icon $icon An instance of the Icon class representing the icon,
     *                             containing properties like prefix and icon name to determine
     *                             the appropriate SVG path.
     * @param bool $withSymbol Determines whether the output should include the <symbol> definition
     *                         for the icon (true) or just the raw path content (false).
     *
     * @return string|null The generated SVG content, either as a <symbol> element or a standalone
     *                     SVG path definition, or null if the icon data cannot be resolved.
     */
    public static function renderIconPath(component\Icon $icon, bool $withSymbol = true): ?string
    {
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
        $name = '_' . strtoupper(str_replace('-', '_', $icon->iconName));
        if ($icon->prefix === 'kit') {
            $name = "_K$name";
        }
        $path = constant("$class::$name");

        $content = is_array($path)
            ? "<path class=\"fa-secondary\" opacity=\".4\" d=\"{$path[0]}\" />" . (empty($path[1])
                ? ''
                : "<path class=\"fa-primary\" d=\"{$path[1]}\" />"
            )
            :"<path fill=\"currentColor\" d=\"{$path}\"/>";
        return $withSymbol
            ? "<symbol id=\"$prefix-{$icon->iconName}\">$content</symbol>"
            : $content;
    }
}
