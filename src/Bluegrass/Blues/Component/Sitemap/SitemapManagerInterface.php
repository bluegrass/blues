<?php

namespace Bluegrass\Blues\Component\Sitemap;

use Symfony\Component\HttpFoundation\Request;

interface SitemapManagerInterface 
{
    function getSitemap();    
    function getCurrentSitemapNode(Request $request);
}

