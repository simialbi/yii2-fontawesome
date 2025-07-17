Yii 2 [Font Awesome](https://fontawesome.com/) Asset Bundle
======================================

This fork of [@rmrevin](https://github.com/rmrevin)'s great [extension](https://github.com/rmrevin/yii2-fontawesome) 
provides a server side rendering implementation of [Font Awesome](https://fontawesome.com/) icons for
[Yii framework 2.0](http://www.yiiframework.com/) applications and helpers to use the icons.

For license information check the [LICENSE](https://github.com/simialbi/yii2-fontawesome/blob/master/LICENSE)-file.

[![License](https://poser.pugx.org/simialbi/yii2-fontawesome/license.svg)](https://packagist.org/packages/simialbi/yii2-fontawesome)
[![Latest Stable Version](https://poser.pugx.org/simialbi/yii2-fontawesome/v/stable.svg)](https://packagist.org/packages/simialbi/yii2-fontawesome)
[![Latest Unstable Version](https://poser.pugx.org/simialbi/yii2-fontawesome/v/unstable.svg)](https://packagist.org/packages/simialbi/yii2-fontawesome)
[![Total Downloads](https://poser.pugx.org/simialbi/yii2-fontawesome/downloads.svg)](https://packagist.org/packages/simialbi/yii2-fontawesome)
[![Build Status](https://github.com/simialbi/yii2-fontawesome/actions/workflows/build.yml/badge.svg)](https://github.com/simialbi/yii2-fontawesome/actions/workflows/build.yml)

Support
-------
* [GitHub issues](https://github.com/simialbi/yii2-fontawesome/issues)

Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/).

Either run

```bash
composer require "simialbi/yii2-fontawesome:^4.0.0"
```

or add

```
"rmrevin/yii2-fontawesome": "^4.0.0",
```

to the `require` section of your `composer.json` file.

How it looks rendered
---------------------
By using this extension, you prevent loading the huge js files of fontawesome and still have all the power features
like `masking`, `power transforms`, `animations` and so on. This library moved the logic and metadata to the server to 
keep the rendering and asset output as small as possible.

An example of what the rendered output looks like on a simple page is as follows: 
```php
<?php
// usage 

use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="utf-8">
        <meta lang="<?= Yii::$app->language; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="none"/>
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode($this->title); ?></title>
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>
    <?= FAS::i('cog'); ?>
    <?= FAS::i('user'); ?>
    <?= FAS::i('cog', ['class' => ['test']])->fixedWidth(); ?>
    <?= $content; ?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>
?>
```

```html
<!-- output -->
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta lang="en-US">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="none"/>
    <title>My test page</title>
    <link href="/assets/93d4929e/css/svg-with-js.css" rel="stylesheet">
</head>
<body>
<svg class="svg-inline--fa fa-cog" aria-hidden="true" focusable="false" role="img" data-prefix="fas" data-icon="cog" viewBox="0 0 512 512"><use href="#fas--cog" /></svg>
<svg class="svg-inline--fa fa-user" aria-hidden="true" focusable="false" role="img" data-prefix="fas" data-icon="user" viewBox="0 0 512 512"><use href="#fas--user" /></svg>
<svg class="svg-inline--fa fa-cog test fa-fw" aria-hidden="true" focusable="false" role="img" data-prefix="fas" data-icon="cog" viewBox="0 0 512 512"><use href="#fas--cog" /></svg>
This is my test content

<svg style="display: none;">
    <symbol id="fas--cog"><path fill="currentColor" d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></symbol>
    <symbol id="fas--user"><path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"></path></symbol>
</svg>
</body>
</html>
```

As you can see, an additional advantage of server side rendering is if you use the same icon multiple times (even with
different style and transformation settings), it's just rendered once and referenced multiple times.


Usage with FontAwesome pro-version
----------------------------------
If you have a pro-version of FontAwesome, download your bundle, extract it and place the `icon-families.json` file
located in `metadata directorty` to a newly created directory `fontawesome-pro` in the root directory of this repository.
Afterward call the `generate-classes.php` file in the `bin` directory:

```bash
php -f ./bin/generate-classes.php
```

Usage with FontAwesome free-version
-----------------------------------
Just call the `generate-classes.php` file in the `bin` directory:

```bash
php -f ./bin/generate-classes.php
```

⚠️ Differences to original repository
-------------------------------------
1. You don't have to register the asset bundle yourself
2. Animations are styles are applied via methods instead of classes
3. `Stack` class is deprecated
4. There is a `Layer` class replacing the stack (https://docs.fontawesome.com/web/style/layer)
5. There are no `duotone` or `sharp` classes anymore (handled via method `->duotone()` and/or `->sharp()`)
6. There are no `ul` and `li` methods anymore (too easy to do yourself) 

Usage examples
--------------

```php
<?php
use rmrevin\yii\fontawesome\FAS;
// or
// use rmrevin\yii\fontawesome\FAB;
// use rmrevin\yii\fontawesome\FAR;
// or (only in pro version https://fontawesome.com/pro)
// use rmrevin\yii\fontawesome\FAL;
// use rmrevin\yii\fontawesome\FAT;
// use rmrevin\yii\fontawesome\FAK;


// normal use
echo FAS::icon('home');

// icon with additional attributes
echo FAS::icon(
    'arrow-left', 
    ['class' => 'big', 'data-role' => 'arrow']
);

// icon in button
echo Html::submitButton(
    Yii::t('app', '{icon} Save', ['icon' => FAS::icon('check')])
);

// icon with additional methods
echo FAS::icon('cog')->sharp(); // (only in pro version https://fontawesome.com/pro)
echo FAS::icon('cog')->duotone(); // (only in pro version https://fontawesome.com/pro)
echo FAS::icon('cog')->inverse(); // only useful in mask or layer usage
echo FAS::icon('cog')->spin(); 
echo FAS::icon('cog')->pulse();
echo FAS::icon('cog')->reverse(); // only useful with spin or pulse
echo FAS::icon('cog')->beat();
echo FAS::icon('cog')->shake();
echo FAS::icon('cog')->bounce();
echo FAS::icon('cog')->fixedWidth(); // or ->fw()
echo FAS::icon('cog')->border();
echo FAS::icon('cog')->pullLeft();
echo FAS::icon('cog')->pullRight();
echo FAS::icon('cog')->flip('horizontal'); // or 'vertical' or 'both'
echo FAS::icon('cog')->size(FAS::SIZE_LARGE); // see FontAwesome::SIZE_ constants for possible values
echo FAS::icon('cog')->transform([
    FAS::TRANSFORM_GROW => 2,
    FAS::TRANSFORM_UP => 5,
    FAS::TRANSFORM_RIGHT => 3
]); // see FontAwesome::TRANSFORM_ constants for possible values
echo FAS::icon('cog')->mask(FAS::i('circle'))->transform(['shrink' => 8]);

//layering icons
echo FAS::layer()
    ->icon(FAS::icon('cog'))
    ->icon(FAS::icon('arrow-up-right-from-square')->transform([
        FAS::TRANSFORM_UP => 8,
        FAS::TRANSFORM_RIGHT => 12,
        FAS::TRANSFORM_SHRINK => 5        
    ]));
?>
```
