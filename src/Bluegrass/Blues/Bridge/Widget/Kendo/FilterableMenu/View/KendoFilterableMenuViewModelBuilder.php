<?php

namespace Bluegrass\Blues\Bridge\Widget\Kendo\FilterableMenu\View;

use Bluegrass\Blues\Component\Widget\View\WidgetViewModel;

use Bluegrass\Blues\Component\Widget\WidgetInterface;
use Bluegrass\Blues\Component\Widget\FilterableMenu\FilterableMenuWidget;
use Bluegrass\Blues\Component\Widget\FilterableMenu\View\FilterableMenuViewModelBuilderInterface;

/**
 *
 * @author ldelia
 */
class KendoFilterableMenuViewModelBuilder implements FilterableMenuViewModelBuilderInterface
{
    /**
     * 
     * @return \Bluegrass\Blues\Component\View\ViewModel
     */
    public function build( WidgetInterface $widget )
    {        
        if (!($widget instanceof FilterableMenuWidget))
            throw new \Exception("Este constructor de ViewModels solo admite instancias de Bluegrass\Blues\Component\Widget\FilterableMenu\FilterableMenuWidget");
                
        return $this->buildInternal($widget);
    }

    /**
     * 
     * @return WidgetViewModel
     */    
    public function buildInternal( FilterableMenuWidget $filterableMenuWidget )
    {          
        $viewModel = new WidgetViewModel();
        $viewModel->setTemplate('@BluegrassBluesWidget/kendo/kendo.html.twig' );
        $viewModel->setBlockName( 'bluegrass_blues_filterablemenu_widget' );
        $viewModel->set( 'menuWidget', $filterableMenuWidget->getMenuWidget()->buildViewModel() );

        return $viewModel;                
    }
}

