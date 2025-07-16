<?php
/**
 * main.php
 * @author Roman Revin http://phptime.ru
 */

$baseDir = realpath(__DIR__ . '/..');

return [
    'id' => 'testapp',
    'basePath' => $baseDir,
    'aliases' => [
        '@web' => '/',
        '@webroot' => $baseDir . '/runtime',
        '@vendor' => realpath($baseDir . '/../vendor'),
        '@bower' => realpath($baseDir . '/../vendor/bower-asset'),
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'wefJDF8sfdsfSDefwqdxj9oq',
            'scriptFile' => $baseDir . '/runtime/index.php',
            'scriptUrl' => '/index.php'
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache'
        ]
    ]
];
