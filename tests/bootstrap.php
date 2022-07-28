<?php
// ensure we get report on all possible php errors
error_reporting(-1);

const YII_ENABLE_ERROR_HANDLER = true;
const YII_DEBUG = true;

$_SERVER['SCRIPT_NAME'] = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require_once(__DIR__ . '/../vendor/autoload.php');

Yii::setAlias('@yiiunit/extensions/fontawesome', __DIR__);
Yii::setAlias('@rmrevin/yii/fontawesome', dirname(__DIR__) . '/src');

require_once(__DIR__ . '/TestCase.php');
