<?php

namespace Bluegrass\Blues\Component\Menu;

use Symfony\Component\HttpFoundation\Request;

interface MenuManagerInterface 
{
    function getMenu();    
    function getCurrentMenuItem( Request $request );
}

