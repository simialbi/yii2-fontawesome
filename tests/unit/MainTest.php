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

        $expected = '<svg id="i0" class="svg-inline--fa fa-cog fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="cog" data-fa-i2svg="" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path></svg>';
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

    public function testStackOutput()
    {
        $this->assertEquals(
            '<span class="fa-stack"><svg id="fa1" class="fa-stack-2x svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" data-fa-i2svg="" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg><svg id="fa0" class="fa-stack-1x fa-inverse svg-inline--fa fa-flag fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="flag" data-fa-i2svg="" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M349.565 98.783C295.978 98.783 251.721 64 184.348 64c-24.955 0-47.309 4.384-68.045 12.013a55.947 55.947 0 0 0 3.586-23.562C118.117 24.015 94.806 1.206 66.338.048 34.345-1.254 8 24.296 8 56c0 19.026 9.497 35.825 24 45.945V488c0 13.255 10.745 24 24 24h16c13.255 0 24-10.745 24-24v-94.4c28.311-12.064 63.582-22.122 114.435-22.122 53.588 0 97.844 34.783 165.217 34.783 48.169 0 86.667-16.294 122.505-40.858C506.84 359.452 512 349.571 512 339.045v-243.1c0-23.393-24.269-38.87-45.485-29.016-34.338 15.948-76.454 31.854-116.95 31.854z"></path></svg></span>',
            (string)FAS::s()->icon('flag')->on('circle')
        );
    }
}