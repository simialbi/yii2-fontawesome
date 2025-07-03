<?php

namespace rmrevin\yii\fontawesome\helpers;

/**
 * {@inheritDoc}
 *
 * @author Simon Karlen <simi.albi@outlook.com>
 */
class Html extends \yii\helpers\Html
{
    /**
     * Checks if the specified CSS class or classes exist within the provided options.
     *
     * @param array $options Reference to the array containing the list of CSS classes.
     * @param string|array $class The CSS class or list of classes to check for existence.
     *
     * @return bool Returns true if the specified class or classes exist, otherwise false.
     */
    public static function hasCssClass(array $options, string|array $class): bool
    {
        if (!isset($options['class'])) {
            return false;
        }
        if (!is_array($options['class'])) {
            $options['class'] = preg_split('/\s+/', $options['class'], -1, PREG_SPLIT_NO_EMPTY);
        }
        $return = true;
        foreach ((array)$class as $c) {
            $return &= in_array($c, $options['class'], true);
        }

        return (bool)$return;
    }
}
