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
     * @return MenuItem
     */
    public function getMenu()
    {
        return $this->menu;
    }

    public function setMenu(MenuItem $menu)
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
                $subMenu = $menu->addChild( $childNode->getLabel(), $childNode->getLabel(), $childNode->getLocation() );
                $this->buildMenuItemFromSitemapNode( $subMenu, $childNode );                
            }
        }
    }
    
    function buildMenuFromSitemap( )
    {
        $sitemapManager = $this->getSitemapManager();
                
        $it = $sitemapManager->getSitemap()->getIterator();
        foreach ( $it as $node ) { 
            
            $menu = new MenuItem( $node->getLabel(), $node->getLabel(), $node->getLocation() );
            $this->buildMenuItemFromSitemapNode( $menu, $node );
            
        }
        return $menu;                
    }
    
    protected abstract function buildMenu();
    
}

