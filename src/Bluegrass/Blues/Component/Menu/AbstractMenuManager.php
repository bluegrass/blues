<?php

namespace Bluegrass\Blues\Component\Menu;

use Bluegrass\Blues\Component\Sitemap\SitemapManagerInterface;
use Bluegrass\Blues\Component\Sitemap\Node;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractMenuManager implements MenuManagerInterface
{
    private $menu;
    private $sitemapManager;
    
    public function __construct( SitemapManagerInterface $sitemapManager )
    {
        $this->setSitemapManager($sitemapManager);        
        $this->setMenu($this->buildMenu());
    }
    
    /**
     * 
     * @return SitemapManagerInterface
     */
    protected function getSitemapManager()
    {
        return $this->sitemapManager;
    }

    protected function setSitemapManager(SitemapManagerInterface $sitemapManager)
    {
        $this->sitemapManager = $sitemapManager;
    }   

    /**
     * 
     * @return Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * 
     * @param \Bluegrass\Blues\Component\Menu\Menu $menu
     */
    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;
    }    
    
    function getCurrentMenuItem( Request $request )
    {
        $currentSitemapNode = $this->getSitemapManager()->getCurrentSitemapNode($request);
        
        $it = new \RecursiveIteratorIterator($this->getMenu()->getIterator(), \RecursiveIteratorIterator::SELF_FIRST);
        foreach ( $it as $menuItem ) { 
            
            $menuItemLocation = $menuItem->getLocation();
            $currentSitemapNodeLocation = $currentSitemapNode->getLocation();
            
            if( $menuItemLocation && $currentSitemapNodeLocation ){
                if( $menuItemLocation->equals( $currentSitemapNodeLocation )  ){
                    return $menuItem;
                }                
            }
        }
        return null;
    }    
    
    protected function buildMenuItemFromSitemapNode( MenuItem $menu, Node $node )
    {        
        foreach ( $node->getChildren() as $childNode ) {             
            if( $childNode->isNavigable() ){
                $subMenu = $menu->addChild( $childNode->getName(), $childNode->getLabel(), $childNode->getLocation() );
                $this->buildMenuItemFromSitemapNode( $subMenu, $childNode );                
            }
        }
    }
    
    /**
     * 
     * @return \Bluegrass\Blues\Component\Menu\Menu
     */
    function buildMenuFromSitemap( $skipRoot = false )
    {
        $it = $this->getSitemapManager()->getSitemap()->getIterator();
        
        if( $skipRoot ){            
            $it = $it ->getChildren();    
        }        
        
        $menu = new Menu();
        
        foreach ( $it as $childNode ) { 
            
            if( $childNode->isNavigable() ){
                $menuItem = new MenuItem( $childNode->getName(), $childNode->getLabel(), $childNode->getLocation() );
                $this->buildMenuItemFromSitemapNode( $menuItem, $childNode );
            
                $menu->addChild($menuItem);
            }
        }
        return $menu;                
    }
    
    /**
     * @return \Bluegrass\Blues\Component\Menu\Menu
     */
    protected abstract function buildMenu();
    
}

