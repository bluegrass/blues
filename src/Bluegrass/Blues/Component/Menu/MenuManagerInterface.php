<?php

namespace Bluegrass\Blues\Component\Menu;

use Symfony\Component\HttpFoundation\Request;

interface MenuManagerInterface 
{
    /**
     * 
     * @return MenuItem
     */    
    function getMenu();    
    
    /**
     * 
     * @return MenuItem
     */    
    function getCurrentMenuItem( Request $request );
}

