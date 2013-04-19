<?php

namespace Bluegrass\Blues\Component\Tests;

use Bluegrass\Blues\Component\Breadcrumb\Sitemap\AbstractDynamicLabelNode;

/**
 * Description of DynamicLabelNodeMock
 *
 * @author gcaseres
 */
class DynamicLabelNodeMock extends AbstractDynamicLabelNode
{
    public function process(array $parameters) 
    {
        $this->setLabel('Nodo parametrizado ' . $parameters['param_1']);
    }
}


