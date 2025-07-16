<?php

namespace rmrevin\yii\fontawesome;

/**
 * Represents the default Font Awesome class for backward compatibility. Prevent usage if possible
 * @package rmrevin\yii\fontawesome
 * @deprecated use FAB FAS FAR FAL FAK FAT classes
 * @see FAS, FAR, FAL, FAK, FAT, FAB
 */
class FA extends FontAwesome
{
    public static $cssPrefix = 'fas';
}
