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
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class Icon
 * @package rmrevin\yii\fontawesome\component
 *
 * @property array $transform
 * @property static|null $mask
 * @property-read array $namespace
 */
class Icon extends BaseObject
{

    /**
     * @var int a counter used to generate [[id]] for icons.
     * @internal
     */
    public static $counter = 0;
    /**
     * @var string the prefix to the automatically generated icon IDs.
     * @see getId()
     */
    public static $autoIdPrefix = 'fa';

    /**
     * @var array
     */
    private static $_rendered = [];

    /**
     * @var string    Style Prefix. One of fas, far, fal, fab. Defaults to fas
     */
    public $prefix = 'fas';

    /**
     * @var string Icon name
     */
    public $iconName;

    /**
     * @var string Title
     */
    public $title;

    /**
     * @var array the HTML attributes for the tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var string Path to `icons.json`
     */
    public $sourcePath;

    /**
     * @var array Font awesome icon namespace
     */
    private $_namespace;

    /**
     * @var array Icon transform
     * @see https://fontawesome.com/how-to-use/on-the-web/styling/power-transforms
     */
    private $_transform = [
        'size' => 16,
        'x' => 0,
        'y' => 0,
        'flipX' => false,
        'flipY' => false,
        'rotate' => 0
    ];

    /**
     * @var array Default transformation values
     * If transform equals this value, no transformation will be applied
     */
    private $_meaninglessTransform = [
        'size' => 16,
        'x' => 0,
        'y' => 0,
        'rotate' => 0,
        'flipX' => false,
        'flipY' => false
    ];

    /**
     * @var static|null Masking icon
     * @see https://fontawesome.com/how-to-use/on-the-web/styling/masking
     */
    private $_mask;

    /**
     * @var array map prefix to json meta data name
     */
    private $_prefixMapping = [
        'fas' => 'solid',
        'far' => 'regular',
        'fal' => 'light',
        'fad' => 'duotone',
        'fab' => 'brands'
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = static::$autoIdPrefix . static::$counter++;
        }
        if (empty($this->sourcePath)) {
            $location = Yii::getAlias('@vendor/fortawesome/font-awesome-pro/metadata/icons.json');
            if (file_exists($location)) {
                $this->sourcePath = $location;
            } else {
                $location = Yii::getAlias('@vendor/fortawesome/font-awesome/metadata/icons.json');
                if (file_exists($location)) {
                    $this->sourcePath = $location;
                }
            }
        }

        AssetBundle::register(Yii::$app->view);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $options = $this->options;
        $options['children'] = [];
        $toHash = $this->prefix . $this->iconName . serialize($this->transform);
        if ($this->mask) {
            $toHash .= $this->mask->iconName . $this->mask->prefix . serialize($this->mask->transform);
        }
        $hash = md5($toHash);

        if (isset(static::$_rendered[$hash])) {
            return Html::tag('svg', Html::tag('use', '', [
                'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
                'xlink:href' => '#' . static::$_rendered[$hash]['id']
            ]), [
                'class' => static::$_rendered[$hash]['class']
            ]);
        }

        $id = ArrayHelper::getValue($options, 'id', '');

        if ($this->mask) {
            $prefix = ArrayHelper::getValue($this->_prefixMapping, $this->mask->prefix, 'solid');
            $_ref = ArrayHelper::getValue($this->namespace, [$this->mask->iconName, 'svg', $prefix]);
        } else {
            $prefix = ArrayHelper::getValue($this->_prefixMapping, $this->prefix, 'solid');
            $_ref = ArrayHelper::getValue($this->namespace, [$this->iconName, 'svg', $prefix]);
        }

        if (!$_ref) {
            return '';
        }

        $width = ArrayHelper::getValue($_ref, 'width');
        $height = ArrayHelper::getValue($_ref, 'height');

        $widthClass = 'fa-w-' . ceil($width / $height * 16);
        static::$_rendered[$hash] = [
            'id' => $id,
            'class' => ['svg-inline--fa', 'fa-' . $this->iconName, $widthClass]
        ];
        Html::addCssClass($options, static::$_rendered[$hash]['class']);

        $options['aria-hidden'] = 'true';
        $options['data'] = ArrayHelper::merge(ArrayHelper::getValue($options, 'data', []), [
            'prefix' => $this->prefix,
            'icon' => $this->iconName,
            'fa-i2svg' => ''
        ]);
        $options['role'] = 'img';
        $options['xmlns'] = 'http://www.w3.org/2000/svg';
        $options['viewBox'] = implode(' ', ArrayHelper::getValue($_ref, 'viewBox', ['0', '0', $width, $height]));

        if ($this->title) {
            $options['children'][] = [
                'tag' => 'title',
                'content' => $this->title,
                'id' => ArrayHelper::getValue($options, 'aria-labelledby', 'title-' . $id)
            ];
        }

        if ($this->mask) {
            $prefix = ArrayHelper::getValue($this->_prefixMapping, $this->prefix, 'solid');
            $_ref2 = ArrayHelper::getValue($this->namespace, [$this->iconName, 'svg', $prefix]);

            $transform = $this->transformForSvg($this->transform, $width, ArrayHelper::getValue($_ref2, 'width'));
            $maskRect = [
                'tag' => 'rect',
                'x' => 0,
                'y' => 0,
                'width' => '100%',
                'height' => '100%',
                'fill' => 'white'
            ];
            $maskInnerGroup = [
                'tag' => 'g',
                'transform' => $transform['inner'],
                'children' => [
                    [
                        'tag' => 'path',
                        'content' => '',
                        'd' => ArrayHelper::getValue($_ref2, 'path'),
                        'transform' => $transform['path'],
                        'fill' => 'black'
                    ]
                ]
            ];
            $maskOuterGroup = [
                'tag' => 'g',
                'transform' => $transform['outer'],
                'children' => [$maskInnerGroup]
            ];
            $maskId = 'mask-' . $id;
            $clipId = 'clip-' . $id;
            $maskTag = [
                'tag' => 'mask',
                'x' => 0,
                'y' => 0,
                'width' => '100%',
                'height' => '100%',
                'id' => $maskId,
                'maskUnits' => 'userSpaceOnUse',
                'maskContentUnits' => 'userSpaceOnUse',
                'children' => [$maskRect, $maskOuterGroup]
            ];

            $options['children'][] = [
                'tag' => 'defs',
                'children' => [
                    [
                        'tag' => 'clipPath',
                        'id' => $clipId,
                        'children' => [
                            [
                                'tag' => 'path',
                                'content' => '',
                                'd' => ArrayHelper::getValue($_ref, 'path')
                            ]
                        ]
                    ],
                    $maskTag
                ]
            ];
            $options['children'][] = [
                'tag' => 'rect',
                'fill' => 'currentColor',
                'clip-path' => 'url(#' . $clipId . ')',
                'mask' => 'url(#' . $maskId . ')',
                'x' => 0,
                'y' => 0,
                'width' => '100%',
                'height' => '100%'
            ];
        } else {
            if ($this->transformIsMeaningful($this->transform)) {
                $transform = $this->transformForSvg($this->transform, $width, $width);
                $options['children'][] = [
                    'tag' => 'g',
                    'transform' => $transform['outer'],
                    'children' => [
                        [
                            'tag' => 'g',
                            'transform' => $transform['inner'],
                            'children' => [
                                [
                                    'tag' => 'path',
                                    'fill' => 'currentColor',
                                    'content' => '',
                                    'd' => ArrayHelper::getValue($_ref, 'path'),
                                    'transform' => $transform['path']
                                ]
                            ]
                        ]
                    ]
                ];
            } else {
                $options['children'][] = $this->asFoundIcon($_ref);
            }
        }

        static::$_rendered[$hash] = [
            'class' => $options['class'],
            'id' => $id
        ];

        $html = Html::beginTag('div', [
            'style' => [
                'visibility' => 'hidden',
                'position' => 'absolute',
                'width' => 0,
                'height' => 0
            ]
        ]);
        Html::removeCssClass($options, ArrayHelper::getValue($this->options, 'class', []));
        $html .= $this->render($options);
        $html .= Html::endTag('div');
        Html::addCssClass($options, ArrayHelper::getValue($this->options, 'class', []));

        $html .= Html::tag('svg', Html::tag('use', '', [
            'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
            'xlink:href' => '#' . static::$_rendered[$hash]['id']
        ]), [
            'class' => $options['class']
        ]);

        return $html; //$this->render($options);
    }

    /**
     * @param array $options
     * @return string
     */
    protected function render(array $options)
    {
        $tag = ArrayHelper::remove($options, 'tag', 'svg');
        $children = ArrayHelper::remove($options, 'children', []);
        $encode = ArrayHelper::remove($options, 'encode', true);
        $content = ArrayHelper::remove($options, 'content');

        if ($content) {
            if ($encode) {
                $content = Html::encode($content);
            }
            return Html::tag($tag, $content, $options);
        }
        $html = Html::beginTag($tag, $options);
        if (is_array($children) && !empty($children)) {
            foreach ($children as $child) {
                $html .= $this->render($child);
            }
        }
        $html .= Html::endTag($tag);

        return $html;
    }

    /**
     * @return array
     */
    public function getNamespace()
    {
        if (!$this->_namespace) {
            $this->_namespace = Yii::$app->cache->getOrSet('fa-namespace', function () {
                if (!file_exists($this->sourcePath)) {
                    return false;
                }

                $data = Json::decode(file_get_contents($this->sourcePath));

                return $data;
            });
        }

        return $this->_namespace;
    }

    /**
     * @return array
     */
    public function getTransform()
    {
        return $this->_transform;
    }

    /**
     * @param array|string $transform
     */
    public function setTransform($transform)
    {
        if (!is_array($transform)) {
            $transform = explode(' ', $transform);
        }
        if (ArrayHelper::isAssociative($transform)) {
            $transform = ArrayHelper::filter($transform, array_keys($this->_transform));
            $this->_transform = array_merge($this->_transform, $transform);
            return;
        }

        foreach ($transform as $n) {
            $parts = explode('-', strtolower($n));
            $first = array_shift($parts);
            $rest = implode('-', $parts);

            if ($first && $rest === 'h') {
                ArrayHelper::setValue($this->_transform, 'flipX', true);
                continue;
            }

            if ($first && $rest === 'v') {
                ArrayHelper::setValue($this->_transform, 'flipY', true);
                continue;
            }

            $rest = floatval($rest);

            if (!is_numeric($rest)) {
                continue;
            }

            switch ($first) {
                case 'grow':
                    $size = ArrayHelper::getValue($this->_transform, 'size', 16);
                    ArrayHelper::setValue($this->_transform, 'size', $size + $rest);
                    break;
                case 'shrink':
                    $size = ArrayHelper::getValue($this->_transform, 'size', 16);
                    ArrayHelper::setValue($this->_transform, 'size', $size - $rest);
                    break;
                case 'left':
                    $x = ArrayHelper::getValue($this->_transform, 'x', 0);
                    ArrayHelper::setValue($this->_transform, 'x', $x - $rest);
                    break;
                case 'right':
                    $x = ArrayHelper::getValue($this->_transform, 'x', 0);
                    ArrayHelper::setValue($this->_transform, 'x', $x + $rest);
                    break;
                case 'up':
                    $y = ArrayHelper::getValue($this->_transform, 'y', 0);
                    ArrayHelper::setValue($this->_transform, 'y', $y - $rest);
                    break;
                case 'down':
                    $y = ArrayHelper::getValue($this->_transform, 'y', 0);
                    ArrayHelper::setValue($this->_transform, 'y', $y + $rest);
                    break;
                case 'rotate':
                    $rotate = ArrayHelper::getValue($this->_transform, 'rotate', 0);
                    ArrayHelper::setValue($this->_transform, 'rotate', $rotate + $rest);
                    break;
                default:
                    continue 2;
            }

            $dataFaTransform = explode(' ', ArrayHelper::getValue($this->options, 'data.fa-transform', ''));
            $dataFaTransform[] = strtolower(trim($n));
            ArrayHelper::setValue($this->options, 'data.fa-transform', trim(implode(' ', $dataFaTransform)));
        }
    }

    /**
     * @return static|null
     */
    public function getMask()
    {
        return $this->_mask;
    }

    /**
     * @param array|string $mask
     */
    public function setMask($mask)
    {
        if (!is_array($mask)) {
            $mask = explode(' ', $mask);
        }
        if (count($mask) === 1) {
            array_unshift($mask, 'fas');
        } elseif (count($mask) !== 2) {
            return;
        }

        $mask[1] = preg_replace('#^fa-#', '', $mask[1]);
        if (ArrayHelper::keyExists($mask[1], $this->namespace, false)) {
            $this->_mask = new static([
                'prefix' => $mask[0],
                'iconName' => strtolower($mask[1])
            ]);

            $mask[1] = 'fa-' . $mask[1];
            ArrayHelper::setValue($this->options, 'data.fa-mask', trim(implode(' ', $mask)));
        }
    }


    /**
     * @return static
     */
    public function inverse()
    {
        Html::addCssClass($this->options, 'fa-inverse');
        return $this;
    }

    /**
     * @return static
     */
    public function spin()
    {
        Html::addCssClass($this->options, 'fa-spin');
        return $this;
    }

    /**
     * @return static
     */
    public function pulse()
    {
        Html::addCssClass($this->options, 'fa-pulse');
        return $this;
    }

    /**
     * @return static
     */
    public function fixedWidth()
    {
        Html::addCssClass($this->options, 'fa-fw');
        return $this;
    }

    /**
     * @return static
     */
    public function border()
    {
        Html::addCssClass($this->options, 'fa-border');
        return $this;
    }

    /**
     * @return static
     */
    public function pullLeft()
    {
        Html::addCssClass($this->options, 'fa-pull-left');
        return $this;
    }

    /**
     * @return static
     */
    public function pullRight()
    {
        Html::addCssClass($this->options, 'fa-pull-right');
        return $this;
    }

    /**
     * @param array|string $transformation
     * @return static
     */
    public function transform($transformation)
    {
        $this->transform = $transformation;

        return $this;
    }

    /**
     * @param array|string $mask
     * @return static
     */
    public function mask($mask)
    {
        $this->mask = $mask;

        return $this;
    }

    /**
     * Checks if a transformation makes sense
     *
     * @param array $transform Transformation to check
     * @return boolean True if transformation makes sense
     */
    private function transformIsMeaningful(array $transform)
    {
        return $transform != $this->_meaninglessTransform;
    }

    /**
     * Split a transformation config array to svg transformation parameters
     *
     * @param array $transform Transformation config array
     * @param integer $containerWidth Width of outer container (mask)
     * @param integer $iconWidth Width of inner container (icon itself)
     * @return array
     */
    private function transformForSvg(array $transform, $containerWidth, $iconWidth)
    {
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
     * @param array $icon
     * @return array
     */
    private function asFoundIcon($icon)
    {
        $vectorData = ArrayHelper::getValue($icon, 'path');

        if (is_array($vectorData)) {
            $element = [
                'tag' => 'g',
                'class' => FontAwesome::$cssPrefix . '-group',
                'children' => [
                    [
                        'tag' => 'path',
                        'class' => FontAwesome::$cssPrefix . '-secondary',
                        'fill' => 'currentColor',
                        'd' => ArrayHelper::getValue($vectorData, 0)
                    ],
                    [
                        'tag' => 'path',
                        'class' => FontAwesome::$cssPrefix . '-primary',
                        'fill' => 'currentColor',
                        'd' => ArrayHelper::getValue($vectorData, 1)
                    ]
                ]
            ];
        } else {
            $element = [
                'tag' => 'path',
                'fill' => 'currentColor',
                'content' => '',
                'd' => $vectorData
            ];
        }

        return $element;
    }
}
