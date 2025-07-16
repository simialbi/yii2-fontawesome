#!/bin/php
<?php

ini_set('memory_limit', '512M');

$file = dirname(__DIR__) . '/fontawesome-pro/icon-families.json';
$isPro = true;

if (!file_exists($file)) {
    $file = dirname(__DIR__) . '/vendor/bower-asset/fontawesome/metadata/icon-families.json';
    $isPro = false;
}
if (!is_dir(dirname(__DIR__) . '/src/icons')) {
    mkdir(dirname(__DIR__) . '/src/icons');
}

$data = json_decode(file_get_contents($file), true);

$solid = [];
$regular = [];
$brands = [];
$light = [];
$thin = [];
$custom = [];
$sizes = [];
foreach ($data as $name => $icon) {
    $name = '_' . strtoupper(str_replace('-', '_', $name));

    foreach ($icon['svgs'] as $family => $styles) {
        foreach ($styles as $style => $meta) {
            if ($style === 'custom') {
                $name = "_K$name";
            }
            $k = match ($family) {
                'classic', 'kit' => 0,
                'duotone' => 1,
                'sharp' => 2,
                'sharp-duotone' => 3
            };
            $$style[$name][$k] = $meta['path'];
            if (!isset($sizes[$name])) {
                $sizes[$name] = [$meta['width'], $meta['height']];
            }
            foreach ($icon['aliases']['names'] ?? [] as $alias) {
                $alias = '_' . strtoupper(str_replace('-', '_', $alias));
                $$style[$alias] = $name;
                if (!isset($sizes[$alias])) {
                    $sizes[$alias] = $name;
                }
            }
        }
    }
}

//var_dump($solid); exit;

foreach (['solid', 'regular', 'brands', 'light', 'thin', 'custom'] as $style) {
    $classes = [
        '' => []
    ];
    if ($style !== 'custom' && $style !== 'brands' && $isPro) {
        $classes = array_merge($classes, [
            'Duotone' => [],
            'Sharp' => [],
            'SharpDuotone' => []
        ]);
    }
    foreach ($$style as $name => $icon) {
        if (is_string($icon)) {
            $classes[''][] = "    const $name = self::$icon;";
            if ($style !== 'custom' && $style !== 'brands' && $isPro) {
                $classes['Duotone'][] = "    const $name = self::$icon;";
                $classes['Sharp'][] = "    const $name = self::$icon;";
                $classes['SharpDuotone'][] = "    const $name = self::$icon;";
            }
            continue;
        }
        $classes[''][] = "    const $name = '{$icon[0]}';";
        if ($style !== 'custom' && $style !== 'brands' && $isPro) {
            $classes['Duotone'][] = "    const $name = ['{$icon[1][0]}', '{$icon[1][1]}'];";
            $classes['Sharp'][] = "    const $name = '{$icon[2]}';";
            $classes['SharpDuotone'][] = "    const $name = ['{$icon[3][0]}', '{$icon[3][1]}'];";
        }
    }

    if (!empty($classes[''])) {
        foreach ($classes as $class => $code) {
            $class = ucfirst($style) . $class;
            $code = implode("\n", $code);
            $code = "<?php\nnamespace rmrevin\yii\\fontawesome\icons;\n\nclass $class\n{\n$code\n}\n";
            $fileName = dirname(__DIR__) . "/src/icons/$class.php";
            file_put_contents($fileName, $code);
        }
    }
}

$code = <<<CODE
<?php
namespace rmrevin\yii\\fontawesome\icons;

class Sizes
{

CODE;
foreach ($sizes as $name => $size) {
    if (is_string($size)) {
        $code .= "    const $name = self::$size;\n";
    } else {
        $code .= "    const $name = [$size[0], $size[1]];\n";
    }
}

$code .= "}\n";

file_put_contents(dirname(__DIR__) . '/src/icons/Sizes.php', $code);
