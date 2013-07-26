<?php

namespace Bluegrass\Blues\Component\Widget\Menu\Builder;

use Bluegrass\Blues\Component\Widget\Builder\WidgetBuilderInterface;

use Bluegrass\Blues\Component\Widget\Menu\Model\MenuWidgetModelInterface;

/**
 *
 * @author ldelia
 */
interface MenuWidgetBuilderInterface extends WidgetBuilderInterface
{
    public function withModel( MenuWidgetModelInterface $menuWidgetModel );
}