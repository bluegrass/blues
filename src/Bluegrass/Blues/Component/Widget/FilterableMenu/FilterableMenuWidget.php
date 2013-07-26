<?php

namespace Bluegrass\Blues\Component\Widget\FilterableMenu;

use Bluegrass\Blues\Component\Widget\AbstractWidget;

use Bluegrass\Blues\Component\Widget\Menu\MenuWidget;
use Bluegrass\Blues\Component\Widget\FilterableMenu\Model\FilterableMenuWidgetModel;
use Bluegrass\Blues\Component\Widget\FilterableMenu\View\FilterableMenuViewModelBuilderInterface;

use Bluegrass\Blues\Component\Menu\MenuItemIterator;

class FilterableMenuWidget extends AbstractWidget implements FilterableMenuWidgetInterface
{    
    private $menuWidget;

    /**
     * 
     * @param FilterableMenuWidgetModel $filterableMenuWidgetModel
     * @param FilterableMenuViewModelBuilder $filterableMenuViewModelBuilder
     */
    public function __construct( FilterableMenuWidgetModel $filterableMenuWidgetModel, FilterableMenuViewModelBuilderInterface $filterableMenuViewModelBuilder )
    {
        parent::__construct($filterableMenuWidgetModel, $filterableMenuViewModelBuilder );
    }    
    
    /**
     * 
     * @return MenuWidget
     */
    public function getMenuWidget()
    {
        return $this->menuWidget;
    }

    public function setMenuWidget(MenuWidget $menuWidget)
    {
        $this->menuWidget = $menuWidget;
    }    
        
    public function filter( $filterPattern )
    {
        if( $filterPattern != "" ){
            $this->getModel()->filter($filterPattern);                        
        }        
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