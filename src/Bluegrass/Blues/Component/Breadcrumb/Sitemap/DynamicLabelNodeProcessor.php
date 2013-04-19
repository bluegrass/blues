<?php

namespace Bluegrass\Blues\Component\Breadcrumb\Sitemap;

use Bluegrass\Blues\Component\Breadcrumb\Sitemap\AbstractDynamicLabelNodeProcessor;
use Bluegrass\Blues\Component\Breadcrumb\Sitemap\DynamicLabelNodeInterface;

/**
 * Procesador de DynamicLabelNode que verifica si el nodo es un DynamicLabelNode
 * y si lo es lo procesa con los parámetros especificados.
 * @author gcaseres
 */
class DynamicLabelNodeProcessor extends AbstractDynamicLabelNodeProcessor
{
    private $parameters;
    
    public function __construct(array $parameters)
    {
        parent::__construct();
        $this->setParameters($parameters);
    }
    
    protected function setParameters(array $value)
    {
        $this->parameters = $value;
    }
    
    protected function getParameters()
    {
        return $this->parameters;
    }
    
    protected function processDynamicNode(DynamicLabelNodeInterface $node) 
    {        
        $node->process($this->getParameters());
    }
}
