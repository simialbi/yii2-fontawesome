#!/bin/php
<?php

$file = dirname(__DIR__) . '/fontawesome-pro/icons.json';

if (!file_exists($file)) {
    $file = dirname(__DIR__) . '/vendor/bower-asset/fontawesome/metadata/icons.json';
}

$data = json_decode(file_get_contents($file), true);

$solid = [];
$regular = [];
$brands = [];
$light = [];
$duotone = [];
$thin = [];
$custom = [];
foreach ($data as $name => $meta) {
    $name = '_' . strtoupper(str_replace('-', '_', $name));
    foreach ($meta['styles'] as $style) {
        $$style[$name] = [$meta['svg'][$style]['width'], $meta['svg'][$style]['height'], $meta['svg'][$style]['path'], $meta['aliases']['names'] ?? []];
    }
}

foreach (['solid', 'regular', 'brands', 'light', 'duotone', 'thin', 'custom'] as $style) {
    $fileName = dirname(__DIR__) . '/src/icons/' . ucfirst($style) . '.php';
    $class = ucfirst($style);
    $code = <<<CODE
<?php
namespace rmrevin\yii\\fontawesome\icons;

class $class
{

CODE;
    foreach ($$style as $name => $icon) {
        if (is_array($icon[2])) {
            $val = implode('\', \'', $icon[2]);
            $code .= "    const $name = [{$icon[0]}, {$icon[1]}, ['$val']];\n";
        } else {
            $code .= "    const $name = [{$icon[0]}, {$icon[1]}, '{$icon[2]}'];\n";
        }

        foreach ($icon[3] as $alias) {
            $alias = '_' . strtoupper(str_replace('-', '_', $alias));
            $code .= "    const $alias = self::$name;\n";
        }
    }

    $code .= "}\n";

    file_put_contents($fileName, $code);
}
