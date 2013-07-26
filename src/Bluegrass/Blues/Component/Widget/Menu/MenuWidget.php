<?php

namespace Bluegrass\Blues\Component\Widget\Menu;

use Bluegrass\Blues\Component\Widget\AbstractWidget;
use Bluegrass\Blues\Component\Widget\Menu\Model\MenuWidgetModelInterface;
use Bluegrass\Blues\Component\Widget\Menu\View\MenuViewModelBuilderInterface;

use Bluegrass\Blues\Component\Menu\MenuItemIterator;

class MenuWidget extends AbstractWidget implements MenuWidgetInterface
{    
    /**
     * 
     * @param \Bluegrass\Blues\Component\Widget\Menu\Model\MenuWidgetModelInterface $menuWidgetModel
     * @param \Bluegrass\Blues\Component\Widget\Menu\Views\MenuViewModelBuilder $viewModelBuilder
     */
    public function __construct( MenuWidgetModelInterface $model, MenuViewModelBuilderInterface $viewModelBuilder )
    {
        parent::__construct($model, $viewModelBuilder);
    }

    /**
     * 
     * @return MenuItemIterator
     */
    public function getIterator()
    {
        return $this->getModel()->getIterator();
    }
}
