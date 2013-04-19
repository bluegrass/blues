<?php

namespace Bluegrass\Blues\Component\Menu;

use Symfony\Component\HttpFoundation\Request;

interface MenuManagerInterface 
{
    /**
     * Obtiene el menú de navegación de la aplicación.
     * 
     */
    function getMenu();
    
}


