<?php

namespace Bluegrass\Blues\Component\Breadcrumb;

use Bluegrass\Blues\Component\Sitemap\SitemapManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Define la interfaz que debe implementar una clase para administrar la
 * generación de Breadcrumbs para un requerimiento dado según un sitemap.
 * 
 * @author gcaseres
 */
interface BreadcrumbManagerInterface 
{
    
    /**
     * Obtiene el breadcrumb para un requerimiento y un sitemap.
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Bluegrass\Blues\Component\Sitemap\SitemapManagerInterface $sitemapManager
     * 
     * @return Bluegrass\Blues\Component\Breadcrumb\Model\Breadcrumb Breadcrumb generado.
     */
    function getBreadcrumb(Request $request, SitemapManagerInterface $sitemapManager);
}
