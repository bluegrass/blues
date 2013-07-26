<?php

namespace Bluegrass\Blues\Bridge\Twig\Extension\Widget\AjaxGrid;

use Bluegrass\Blues\Component\Widget\AjaxGrid\View\AjaxGridWidgetContentViewModel;

class AjaxGridWidgetExtension extends \Twig_Extension
{
    private $environment;

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment) 
    {
        $this->environment = $environment;
        
        $menuExtensionReflection = new \ReflectionClass("Bluegrass\Blues\Bridge\Twig\Extension\Widget\AjaxGrid\AjaxGridWidgetExtension");
        $menuExtensionReflectionDir = dirname($menuExtensionReflection->getFilename()).'/../../../Resources/views/Widget';        
        
        if (is_dir( $menuExtensionReflectionDir )) {
            $this->environment->getLoader()->addPath( $menuExtensionReflectionDir, "BluegrassBluesWidgetAjaxGrid");
        }        
    }    
        
    public function getName()
    {
        return 'bluegrass_blues_widget_ajaxgrid_extension';
    }    
    
    public function getFunctions()
    {
        return array(
            'bluegrass_blues_widget_ajaxgrid_content'  => new \Twig_Function_Method($this, 'renderBluegrassBluesWidgetAjaxGridContent', array('is_safe' => array('html'))),            
        );
    }
    
    function renderBluegrassBluesWidgetAjaxGridContent( AjaxGridWidgetContentViewModel $contentViewModel )
    {                    
        $template = $this->environment->loadTemplate( $contentViewModel->getTemplate() );
        
        return $template->renderBlock( 'bluegrass_blues_widget_ajaxgrid_content' , array( 'view' => $contentViewModel ) );
    }    
}

