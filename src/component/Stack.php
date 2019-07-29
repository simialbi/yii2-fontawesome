<?php
/**
 * Stack.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome\component;

use rmrevin\yii\fontawesome\FontAwesome;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Stack
 * @package rmrevin\yii\fontawesome\component
 */
class Stack extends BaseObject
{
    /**
     * @var string
     */
    public $prefix = 'fas';

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var Icon
     */
    private $_icon_front;

    /**
     * @var string
     */
    private $_text_front = null;

    /**
     * @var Icon
     */
    private $_icon_back;

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function __toString()
    {
        $options = $this->options;

        Html::addCssClass($options, ['widget' => 'fa-stack']);

        $tag = ArrayHelper::remove($options, 'tag', 'span');

        $template = ArrayHelper::remove($options, 'template', '{back}{front}');

        $iconBack = '';
        if ($this->_icon_back instanceof Icon) {
            Html::addCssClass($this->_icon_back->options, FontAwesome::$basePrefix . '-stack-2x');
            $iconBack = $this->_icon_back;
        }
        if ($this->_text_front !== null) {
            $contentFront = $this->_text_front;
        } else {
            if ($this->_icon_front instanceof Icon) {
                Html::addCssClass($this->_icon_front->options, [
                    FontAwesome::$basePrefix . '-stack-1x',
                    FontAwesome::$basePrefix . '-inverse'
                ]);
            }
            $contentFront = $this->_icon_front;
        }

        $content = str_replace(['{back}', '{front}'], [$iconBack, $contentFront], $template);

        return Html::tag($tag, $content, $options);
    }

    /**
     * @param string|Icon $icon
     * @param array $options
     * @return \rmrevin\yii\fontawesome\component\Stack
     */
    public function icon($icon, $options = [])
    {
        if (is_string($icon)) {
            $icon = new Icon([
                'iconName' => $icon,
                'options' => $options,
                'prefix' => $this->prefix
            ]);
        }

        $this->_icon_front = $icon;

        return $this;
    }

    /**
     * @param string $text
     * @param array $options
     * @return \rmrevin\yii\fontawesome\component\Stack
     */
    public function text($text = '', $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'span');

        Html::addCssClass($options, FontAwesome::$basePrefix . '-stack-1x');

        $this->_text_front = Html::tag($tag, $text, $options);

        return $this;
    }

    /**
     * @param string|Icon $icon
     * @param array $options
     * @return \rmrevin\yii\fontawesome\component\Stack
     */
    public function on($icon, $options = [])
    {
        if (is_string($icon)) {
            $icon = new Icon([
                'iconName' => $icon,
                'options' => $options,
                'prefix' => $this->prefix
            ]);
        }

        $this->_icon_back = $icon;

        return $this;
    }
}
