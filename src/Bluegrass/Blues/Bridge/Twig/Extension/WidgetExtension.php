<?php

namespace Bluegrass\Blues\Bridge\Twig\Extension;

use Bluegrass\Blues\Component\Views\ViewModel;

class WidgetExtension extends \Twig_Extension
{
    private $environment;

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment) 
    {
        $this->environment = $environment;
        
        $menuExtensionReflection = new \ReflectionClass("Bluegrass\Blues\Bridge\Twig\Extension\WidgetExtension");
        $menuExtensionReflectionDir = dirname($menuExtensionReflection->getFilename()).'/../Resources/views/Widget';        
        
        if (is_dir( $menuExtensionReflectionDir )) {
            $this->environment->getLoader()->addPath( $menuExtensionReflectionDir, "BluegrassBluesWidget");
        }        
    }    
        
    public function getName()
    {
        return 'bluegrass_blues_widget_extension';
    }    
    
    public function getFunctions()
    {
        return array(
            'bluegrass_blues_widget'  => new \Twig_Function_Method($this, 'renderBluegrassBluesWidget', array('is_safe' => array('html'))),            
        );
    }
    
    function renderBluegrassBluesWidget( ViewModel $view )
    {                    
        $template = $this->environment->loadTemplate('@BluegrassBluesWidget/blocks.html.twig');
        
        return $template->renderBlock( $view->get('blockName') , array( 'view' => $view ) );
    }    
}

