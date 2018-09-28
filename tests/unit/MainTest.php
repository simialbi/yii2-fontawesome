<?php
/**
 * MainTest.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace yiiunit\extensions\fontawesome;

use rmrevin\yii\fontawesome\FAR;
use rmrevin\yii\fontawesome\FontAwesome;

/**
 * Class MainTest
 * @package rmrevin\yii\fontawesome\tests\unit\fontawesome
 */
class MainTest extends TestCase
{

    public function testMain()
    {
        $this->assertInstanceOf('rmrevin\yii\fontawesome\FAR', new FAR());
        $this->assertInstanceOf('rmrevin\yii\fontawesome\FontAwesome', new FAR());

        $this->assertInstanceOf('rmrevin\yii\fontawesome\FontAwesome', new FontAwesome());

        $Icon = FAR::icon('cog');
        $this->assertInstanceOf('rmrevin\yii\fontawesome\component\Icon', $Icon);

        $Stack = FAR::stack();
        $this->assertInstanceOf('rmrevin\yii\fontawesome\component\Stack', $Stack);
    }

//    public function testStackOutput()
//    {
//        $this->assertEquals(
//            (string)FAR::s(),
//            '<span class="fa-stack"></span>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::stack(),
//            '<span class="fa-stack"></span>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::stack(['tag' => 'div']),
//            '<div class="fa-stack"></div>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::stack()
//                ->icon('cog'),
//            '<span class="fa-stack"><i class="far fa-cog fa-stack-1x"></i></span>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::stack()
//                ->on('square-o'),
//            '<span class="fa-stack"><i class="far fa-square-o fa-stack-2x"></i></span>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::stack()
//                ->icon('cog')
//                ->on('square-o'),
//            '<span class="fa-stack"><i class="far fa-square-o fa-stack-2x"></i><i class="far fa-cog fa-stack-1x"></i></span>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::stack(['data-role' => 'stack'])
//                ->icon('cog', ['data-role' => 'icon',])
//                ->on('square-o', ['data-role' => 'background']),
//            '<span class="fa-stack" data-role="stack"><i class="far fa-square-o fa-stack-2x" data-role="background"></i><i class="far fa-cog fa-stack-1x" data-role="icon"></i></span>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::stack()
//                ->icon(FAR::icon('cog')->spin())
//                ->on(FAR::icon('square-o')->size(FAR::SIZE_3X)),
//            '<span class="fa-stack"><i class="far fa-square-o fa-3x fa-stack-2x"></i><i class="far fa-cog fa-spin fa-stack-1x"></i></span>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::stack()
//                ->icon(FAR::Icon('cog')->spin())
//                ->on(FAR::Icon('square-o')->size(FAR::SIZE_3X)),
//            '<span class="fa-stack"><i class="far fa-square-o fa-3x fa-stack-2x"></i><i class="far fa-cog fa-spin fa-stack-1x"></i></span>'
//        );
//
//        $this->assertNotEquals(
//            (string)FAR::stack()
//                ->icon((string)FAR::Icon('cog')->spin())
//                ->on((string)FAR::Icon('square-o')->size(FAR::SIZE_3X)),
//            '<span class="fa-stack"><i class="far fa-square-o fa-3x fa-stack-2x"></i><i class="far fa-cog fa-spin fa-stack-1x"></i></span>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::stack()
//                ->text('hot')
//                ->on('square-o'),
//            '<span class="fa-stack"><i class="far fa-square-o fa-stack-2x"></i><span class="fa-stack-1x">hot</span></span>'
//        );
//    }

//    public function testUlOutput()
//    {
//        $this->assertEquals(
//            (string)FAR::ul(),
//            '<ul class="fa-ul"></ul>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::ul()
//                ->item('Gear'),
//            "<ul class=\"fa-ul\">\n<li>Gear</li>\n</ul>"
//        );
//
//        $this->assertEquals(
//            (string)FAR::ul()
//                ->item('Gear', ['icon' => 'cog']),
//            "<ul class=\"fa-ul\">\n<li><i class=\"far fa-cog fa-li\"></i>Gear</li>\n</ul>"
//        );
//
//        $this->assertEquals(
//            (string)FAR::ul()
//                ->item('Check', ['icon' => 'check'])
//                ->item('Gear', ['icon' => 'cog']),
//            "<ul class=\"fa-ul\">\n<li><i class=\"far fa-check fa-li\"></i>Check</li>\n<li><i class=\"far fa-cog fa-li\"></i>Gear</li>\n</ul>"
//        );
//
//        $this->assertEquals(
//            (string)FAR::ul(['tag' => 'ol'])
//                ->item('Check', ['icon' => 'check'])
//                ->item('Gear', ['icon' => 'cog']),
//            "<ol class=\"fa-ul\">\n<li><i class=\"far fa-check fa-li\"></i>Check</li>\n<li><i class=\"far fa-cog fa-li\"></i>Gear</li>\n</ol>"
//        );
//
//        $this->assertEquals(
//            (string)FAR::ul()
//                ->item('Check', ['icon' => 'check', 'class' => 'another-class']),
//            "<ul class=\"fa-ul\">\n<li class=\"another-class\"><i class=\"far fa-check fa-li\"></i>Check</li>\n</ul>"
//        );
//    }

//    public function testAnotherPrefix()
//    {
//        FontAwesome::$basePrefix = 'fontawesome';
//
//        $this->assertEquals((string)FAR::icon('cog'), '<i class="far fontawesome-cog"></i>');
//        $this->assertEquals((string)FAR::icon('cog', ['tag' => 'span']), '<span class="far fontawesome-cog"></span>');
//        $this->assertEquals((string)FAR::icon('cog')->addCssClass('highlight'),
//            '<i class="far fontawesome-cog highlight"></i>');
//
//        $this->assertEquals(
//            (string)FAR::stack()
//                ->icon(FAR::Icon('cog')->spin())
//                ->on(FAR::Icon('square-o')->size(FAR::SIZE_3X)),
//            '<span class="fontawesome-stack"><i class="far fontawesome-square-o fontawesome-3x fontawesome-stack-2x"></i><i class="far fontawesome-cog fontawesome-spin fontawesome-stack-1x"></i></span>'
//        );
//
//        $this->assertEquals(
//            (string)FAR::ul()
//                ->item('Gear', ['icon' => 'cog']),
//            "<ul class=\"fontawesome-ul\">\n<li><i class=\"far fontawesome-cog fontawesome-li\"></i>Gear</li>\n</ul>"
//        );
//
//        FontAwesome::$basePrefix = 'fa';
//    }

    public function testIconOutput()
    {
        $this->assertEquals((string)FAR::i('cog'), '<svg id="i0" class="svg-inline--fa fa-cog fa-w-16" aria-hidden="true" data-prefix="far" data-icon="cog" data-fa-i2svg="" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M452.515 237l31.843-18.382c9.426-5.441 13.996-16.542 11.177-27.054-11.404-42.531-33.842-80.547-64.058-110.797-7.68-7.688-19.575-9.246-28.985-3.811l-31.785 18.358a196.276 196.276 0 0 0-32.899-19.02V39.541a24.016 24.016 0 0 0-17.842-23.206c-41.761-11.107-86.117-11.121-127.93-.001-10.519 2.798-17.844 12.321-17.844 23.206v36.753a196.276 196.276 0 0 0-32.899 19.02l-31.785-18.358c-9.41-5.435-21.305-3.877-28.985 3.811-30.216 30.25-52.654 68.265-64.058 110.797-2.819 10.512 1.751 21.613 11.177 27.054L59.485 237a197.715 197.715 0 0 0 0 37.999l-31.843 18.382c-9.426 5.441-13.996 16.542-11.177 27.054 11.404 42.531 33.842 80.547 64.058 110.797 7.68 7.688 19.575 9.246 28.985 3.811l31.785-18.358a196.202 196.202 0 0 0 32.899 19.019v36.753a24.016 24.016 0 0 0 17.842 23.206c41.761 11.107 86.117 11.122 127.93.001 10.519-2.798 17.844-12.321 17.844-23.206v-36.753a196.34 196.34 0 0 0 32.899-19.019l31.785 18.358c9.41 5.435 21.305 3.877 28.985-3.811 30.216-30.25 52.654-68.266 64.058-110.797 2.819-10.512-1.751-21.613-11.177-27.054L452.515 275c1.22-12.65 1.22-25.35 0-38zm-52.679 63.019l43.819 25.289a200.138 200.138 0 0 1-33.849 58.528l-43.829-25.309c-31.984 27.397-36.659 30.077-76.168 44.029v50.599a200.917 200.917 0 0 1-67.618 0v-50.599c-39.504-13.95-44.196-16.642-76.168-44.029l-43.829 25.309a200.15 200.15 0 0 1-33.849-58.528l43.819-25.289c-7.63-41.299-7.634-46.719 0-88.038l-43.819-25.289c7.85-21.229 19.31-41.049 33.849-58.529l43.829 25.309c31.984-27.397 36.66-30.078 76.168-44.029V58.845a200.917 200.917 0 0 1 67.618 0v50.599c39.504 13.95 44.196 16.642 76.168 44.029l43.829-25.309a200.143 200.143 0 0 1 33.849 58.529l-43.819 25.289c7.631 41.3 7.634 46.718 0 88.037zM256 160c-52.935 0-96 43.065-96 96s43.065 96 96 96 96-43.065 96-96-43.065-96-96-96zm0 144c-26.468 0-48-21.532-48-48 0-26.467 21.532-48 48-48s48 21.533 48 48c0 26.468-21.532 48-48 48z"></path></svg>');
//        $this->assertEquals(FAR::icon('cog'), '<i class="far fa-cog"></i>');
//        $this->assertEquals(FAR::icon('cog', ['tag' => 'span']), '<span class="far fa-cog"></span>');
//        $this->assertEquals(FAR::icon('cog')->addCssClass('highlight'), '<i class="far fa-cog highlight"></i>');
//
//        $this->assertEquals(FAR::icon('cog')->inverse(), '<i class="far fa-cog fa-inverse"></i>');
//        $this->assertEquals(FAR::icon('cog')->spin(), '<i class="far fa-cog fa-spin"></i>');
//        $this->assertEquals(FAR::icon('cog')->pulse(), '<i class="far fa-cog fa-pulse"></i>');
//        $this->assertEquals(FAR::icon('cog')->fixedWidth(), '<i class="far fa-cog fa-fw"></i>');
//        $this->assertEquals(FAR::icon('cog')->li(), '<i class="far fa-cog fa-li"></i>');
//        $this->assertEquals(FAR::icon('cog')->border(), '<i class="far fa-cog fa-border"></i>');
//        $this->assertEquals(FAR::icon('cog')->pullLeft(), '<i class="far fa-cog fa-pull-left"></i>');
//        $this->assertEquals(FAR::icon('cog')->pullRight(), '<i class="far fa-cog fa-pull-right"></i>');
//
//        $this->assertEquals(FAR::icon('cog')->size(FAR::SIZE_2X), '<i class="far fa-cog fa-2x"></i>');
//        $this->assertEquals(FAR::icon('cog')->size(FAR::SIZE_3X), '<i class="far fa-cog fa-3x"></i>');
//        $this->assertEquals(FAR::icon('cog')->size(FAR::SIZE_4X), '<i class="far fa-cog fa-4x"></i>');
//        $this->assertEquals(FAR::icon('cog')->size(FAR::SIZE_5X), '<i class="far fa-cog fa-5x"></i>');
//        $this->assertEquals(FAR::icon('cog')->size(FAR::SIZE_LARGE), '<i class="far fa-cog fa-lg"></i>');
//
//        $this->assertEquals(FAR::icon('cog')->rotate(FAR::ROTATE_90), '<i class="far fa-cog fa-rotate-90"></i>');
//        $this->assertEquals(FAR::icon('cog')->rotate(FAR::ROTATE_180), '<i class="far fa-cog fa-rotate-180"></i>');
//        $this->assertEquals(FAR::icon('cog')->rotate(FAR::ROTATE_270), '<i class="far fa-cog fa-rotate-270"></i>');
//
//        $this->assertEquals(FAR::icon('cog')->flip(FAR::FLIP_HORIZONTAL),
//            '<i class="far fa-cog fa-flip-horizontal"></i>');
//        $this->assertEquals(FAR::icon('cog')->flip(FAR::FLIP_VERTICAL), '<i class="far fa-cog fa-flip-vertical"></i>');
    }

//    public function testIconSizeException()
//    {
//        $this->setExpectedException(
//            'yii\base\InvalidConfigException',
//            'FontAwesome::size() - invalid value. Use one of the constants: FontAwesome::SIZE_LARGE, FontAwesome::SIZE_2X, FontAwesome::SIZE_3X, FontAwesome::SIZE_4X, FontAwesome::SIZE_5X.'
//        );
//
//        FAR::icon('cog')->size('badvalue');
//    }
//
//    public function testIconRotateException()
//    {
//        $this->setExpectedException(
//            'yii\base\InvalidConfigException',
//            'FontAwesome::rotate() - invalid value. Use one of the constants: FontAwesome::ROTATE_90, FontAwesome::ROTATE_180, FontAwesome::ROTATE_270.'
//        );
//
//        FAR::icon('cog')->rotate('badvalue');
//    }
//
//    public function testIconFlipException()
//    {
//        $this->setExpectedException(
//            'yii\base\InvalidConfigException',
//            'FontAwesome::flip() - invalid value. Use one of the constants: FontAwesome::FLIP_HORIZONTAL, FontAwesome::FLIP_VERTICAL.'
//        );
//
//        FAR::icon('cog')->flip('badvalue');
//    }
//
//    public function testIconAddCssClassCondition()
//    {
//        $this->assertEquals(FAR::$cssPrefix, 'far');
//        $this->assertEquals((string)FAR::icon('cog')->addCssClass('highlight', true),
//            '<i class="far fa-cog highlight"></i>');
//
//        $this->setExpectedException(
//            'yii\base\InvalidConfigException',
//            'Condition is false'
//        );
//
//        FAR::icon('cog')->addCssClass('highlight', false, true);
//    }
}