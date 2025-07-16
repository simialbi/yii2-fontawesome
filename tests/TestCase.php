<?php
/**
 * TestCase.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace yiiunit\extensions\fontawesome;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class TestCase
 * @package rmrevin\yii\fontawesome\tests\unit
 * This is the base class for all yii framework unit tests.
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{

    public static ?array $params = null;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockWebApplication();
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown(): void
    {
        parent::tearDown();

        restore_error_handler();
        restore_exception_handler();
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     * @param string $appClass
     */
    protected function mockWebApplication(string $appClass = '\yii\web\Application'): void
    {
        // for update self::$params
        $this->getParam('id');

        /** @var \yii\web\Application $app */
        new $appClass(self::$params);
    }

    /**
     * Returns a test configuration param from /data/config.php
     * @param string $name params name
     * @param mixed $default default value to use when param is not set.
     * @return mixed the value of the configuration param
     */
    public function getParam(string $name, mixed $default = null): mixed
    {
        if (self::$params === null) {
            self::$params = require(__DIR__ . '/config/main.php');
            $main_local = __DIR__ . '/config/main-local.php';
            if (file_exists($main_local)) {
                self::$params = ArrayHelper::merge(self::$params, require($main_local));
            }
        }

        return self::$params[$name] ?? $default;
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyWebApplication(): void
    {
        Yii::$app = null;
    }
}
