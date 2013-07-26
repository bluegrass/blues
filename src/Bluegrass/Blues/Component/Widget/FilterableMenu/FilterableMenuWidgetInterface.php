<?php

namespace Bluegrass\Blues\Component\Widget\FilterableMenu;

use Bluegrass\Blues\Component\Widget\WidgetInterface;
use Bluegrass\Blues\Component\Menu\MenuItemIterator;

/**
 *
 * @author ldelia
 */
interface FilterableMenuWidgetInterface extends WidgetInterface
{
    /**
     * 
     * @return MenuItemIterator
     */
    public function getIterator();
}
