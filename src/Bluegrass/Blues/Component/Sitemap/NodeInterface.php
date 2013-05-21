<?php

namespace Bluegrass\Blues\Component\Sitemap;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;

/**
 * Interfaz que debe implementar un nodo de un Sitemap.
 */
interface NodeInterface 
{
    function getLocation();
    function isNavigable();
    function getName();
    function getLabel();
    function getChildren();
    function setParent(Node $value);
    function getParent();
    function addChild(NodeInterface $node);
    function hasParent();
    function hasChildren();    
}

