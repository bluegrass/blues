<?php

namespace Bluegrass\Blues\Bridge\Twig\Extension;

use Bluegrass\Blues\Component\Menu\MenuItem;

class MenuExtension extends \Twig_Extension
{
    private $environment;

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment) {
        $this->environment = $environment;
        
        $menuExtensionReflection = new \ReflectionClass("Bluegrass\Blues\Bridge\Twig\Extension\MenuExtension");
        $menuExtensionReflectionDir = dirname($menuExtensionReflection->getFilename()).'/../Resources/views/Menu';        
        
        if (is_dir( $menuExtensionReflectionDir )) {
            $this->environment->getLoader()->addPath( $menuExtensionReflectionDir, "BluegrassBluesMenu");
        }
        
    }    
        
    public function getName()
    {
        return 'bluegrass_blues_menu_extension';
    }    
    
    public function getFunctions()
    {
        return array(
            'bluegrass_blues_menu'  => new \Twig_Function_Method($this, 'renderBluegrassBluesMenu', array('is_safe' => array('html'))),            
        );
    }
    
    function renderBluegrassBluesMenu( MenuItem $menu ){
                       
        $template = $this->environment->loadTemplate('@BluegrassBluesMenu/menu.html.twig');
        
        return $template->renderBlock( 'bluegrass_blues_menu', array( 'menu' => $menu ) );
    }    
}

