<?php

namespace rmrevin\yii\fontawesome\component;

use rmrevin\yii\fontawesome\FAS;

/**
 * Class Stack
 * @deprecated Use Layer class instead.
 */
class Stack extends Layer
{
    /**
     * Set the base icon with the given options.
     *
     * @param string|Icon $icon The icon to be added, either as a string identifier or an Icon object.
     * @param array $options Additional options for the icon configuration.
     *
     * @return Stack The updated stack instance.
     * @deprecated Use add method
     */
    public function on(string|Icon $icon, array $options = []): Stack
    {
        if (is_string($icon)) {
            $icon = FAS::i($icon);
        }
        return $this->add($icon, $options, true);
    }
}
