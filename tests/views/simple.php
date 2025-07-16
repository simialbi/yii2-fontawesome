<?php

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
    <?= $content; ?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>
