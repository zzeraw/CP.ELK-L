<?php
/**
 *
 */
class MInlineWidgetsBehavior extends DInlineWidgetsBehavior
{
    /**
     * @var mixed alias if needle using default location 'path.to.widgets'
     */
    public $location = '';

    protected function _loadWidget($name, $attributes='')
    {
        $attrs = $this->_parseAttributes($attributes);
        $cache = $this->_extractCacheExpireTime($attrs);

        $index = 'widget_' . $name . '_' . serialize($attrs);

        if ($cache && $cachedHtml = Yii::app()->cache->get($index))
        {
            $html = $cachedHtml;
        }
        else
        {
            ob_start();
            $widgetClass = $this->_getFullClassName($name);

            $path = Yii::getpathOfAlias($widgetClass);
            if (!file_exists($path . '.php')) {
                return false;
            }

            $widget = Yii::app()->getWidgetFactory()->createWidget($this->owner, $widgetClass, $attrs);
            $widget->init();
            $widget->run();
            $html = trim(ob_get_clean());
            // Yii::app()->cache->set($index, $html, $cache);
        }

        return $html;
    }

    protected function _getFullClassName($name)
    {
        $widgetClass = $name . $this->classSuffix;

        if (!is_array($this->location)) {
            $locations[] = $this->location;
        } else {
            $locations = $this->location;
        }

        foreach ($locations as $location) {
            if ($this->_getClassByAlias($widgetClass) == $widgetClass && $location) {
                $widgetClassWithLocation = $location . '.' . $widgetClass;
            }

            $path = Yii::getpathOfAlias($widgetClassWithLocation);

            if (!file_exists($path . '.php')) {
                continue;
            } else {
                return $widgetClassWithLocation;
            }
        }

        return $widgetClassWithLocation;
    }

    protected function _processWidgets($text)
    {
        if (preg_match('|\~' . $this->_widgetToken . ':.+?' . $this->_widgetToken . '\~|is', $text))
        {
            foreach ($this->widgets as $alias)
            {
                $widget = $this->_getClassByAlias($alias);

                while (preg_match('#\~' . $this->_widgetToken . ':' . $widget . '(\|([^~]*)?)?' . $this->_widgetToken . '\~#is', $text, $p))
                {
                    $text = str_replace($p[0], $this->_loadWidget($alias, isset($p[2]) ? $p[2] : ''), $text);
                }
            }
            return $text;
        }
        return $text;
    }

    protected function _clearWidgets($text)
    {
        return preg_replace('|\~' . $this->_widgetToken . ':.+?' . $this->_widgetToken . '\~|is', '', $text);
    }

    protected function _replaceBlocks($text)
    {
        $text = str_replace($this->startBlock, '~' . $this->_widgetToken . ':', $text);
        $text = str_replace($this->endBlock, $this->_widgetToken . '~', $text);
        return $text;
    }


}