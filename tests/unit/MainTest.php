<?php
/**
 * MainTest.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace yiiunit\extensions\fontawesome;

use rmrevin\yii\fontawesome\component\Icon;
use rmrevin\yii\fontawesome\FAR;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FontAwesome;

/**
 * Class MainTest
 * @package rmrevin\yii\fontawesome\tests\unit\fontawesome
 */
class MainTest extends TestCase
{

    public function testMain()
    {
        Icon::$counter = 0;
        $this->assertInstanceOf('rmrevin\yii\fontawesome\FAR', new FAR());
        $this->assertInstanceOf('rmrevin\yii\fontawesome\FontAwesome', new FAR());

        $this->assertInstanceOf('rmrevin\yii\fontawesome\FontAwesome', new FontAwesome());

        $Icon = FAR::icon('cog');
        $this->assertInstanceOf('rmrevin\yii\fontawesome\component\Icon', $Icon);

        $Stack = FAR::stack();
        $this->assertInstanceOf('rmrevin\yii\fontawesome\component\Stack', $Stack);
    }

    public function testIconOutput()
    {
        Icon::$counter = 0;

        $expected = '<svg id="i0" class="svg-inline--fa fa-cog fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="cog" data-fa-i2svg="" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M444.788 291.1l42.616 24.599c4.867 2.809 7.126 8.618 5.459 13.985-11.07 35.642-29.97 67.842-54.689 94.586a12.016 12.016 0 0 1-14.832 2.254l-42.584-24.595a191.577 191.577 0 0 1-60.759 35.13v49.182a12.01 12.01 0 0 1-9.377 11.718c-34.956 7.85-72.499 8.256-109.219.007-5.49-1.233-9.403-6.096-9.403-11.723v-49.184a191.555 191.555 0 0 1-60.759-35.13l-42.584 24.595a12.016 12.016 0 0 1-14.832-2.254c-24.718-26.744-43.619-58.944-54.689-94.586-1.667-5.366.592-11.175 5.459-13.985L67.212 291.1a193.48 193.48 0 0 1 0-70.199l-42.616-24.599c-4.867-2.809-7.126-8.618-5.459-13.985 11.07-35.642 29.97-67.842 54.689-94.586a12.016 12.016 0 0 1 14.832-2.254l42.584 24.595a191.577 191.577 0 0 1 60.759-35.13V25.759a12.01 12.01 0 0 1 9.377-11.718c34.956-7.85 72.499-8.256 109.219-.007 5.49 1.233 9.403 6.096 9.403 11.723v49.184a191.555 191.555 0 0 1 60.759 35.13l42.584-24.595a12.016 12.016 0 0 1 14.832 2.254c24.718 26.744 43.619 58.944 54.689 94.586 1.667 5.366-.592 11.175-5.459 13.985L444.788 220.9a193.485 193.485 0 0 1 0 70.2zM336 256c0-44.112-35.888-80-80-80s-80 35.888-80 80 35.888 80 80 80 80-35.888 80-80z"></path></svg>';
        $this->assertEquals($expected, (string)FAS::i('cog'));
    }

    public function testAdvancedIconMaskOutput()
    {
        Icon::$counter = 0;
        $this->assertEquals(
            '<svg id="i0" class="fa-fw svg-inline--fa fa-comment fa-w-16" data-fa-mask="fas fa-circle" data-fa-transform="shrink-8" data-prefix="fas" data-icon="comment" data-fa-i2svg="" aria-hidden="true" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><defs><clipPath id="clip-i0"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></clipPath><mask id="mask-i0" width="100%" height="100%" x="0" y="0" maskUnits="userSpaceOnUse" maskContentUnits="userSpaceOnUse"><rect width="100%" height="100%" x="0" y="0" fill="white"></rect><g transform="translate(256 256)"><g transform="translate(0, 0) scale(0.5, 0.5) rotate(0 0 0)"><path d="M256 32C114.6 32 0 125.1 0 240c0 49.6 21.4 95 57 130.7C44.5 421.1 2.7 466 2.2 466.5c-2.2 2.3-2.8 5.7-1.5 8.7S4.8 480 8 480c66.3 0 116-31.8 140.6-51.4 32.7 12.3 69 19.4 107.4 19.4 141.4 0 256-93.1 256-208S397.4 32 256 32z" transform="translate(-256 -256)" fill="black"></path></g></g></mask></defs><rect width="100%" height="100%" fill="currentColor" clip-path="url(#clip-i0)" mask="url(#mask-i0)" x="0" y="0"></rect></svg>',
            (string)FAS::i('comment')->mask('fas fa-circle')->transform('shrink-8')->fixedWidth()
        );
    }
}