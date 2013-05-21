<?php

namespace Bluegrass\Blues\Component\Widgets\Breadcrumb;

use Bluegrass\Blues\Component\Breadcrumb\Model\Breadcrumb as BreadcrumbModel;
use Bluegrass\Blues\Component\Breadcrumb\Model\Item;
use Bluegrass\Blues\Component\Widgets\WidgetInterface;
use IteratorAggregate;

/**
 * Componente visual para la representación de un breadcrumb.
 *
 * @author gcaseres
 */
class BreadcrumbWidget implements WidgetInterface, IteratorAggregate
{
    private $model;
    
    public function __construct(BreadcrumbModel $model)
    {
        $this->setModel($model);
    }
    
    protected function setModel(BreadcrumbModel $value)
    {   
        $this->model = $value;
    }
    
    /**
     * 
     * @return Bluegrass\Blues\Component\Breadcrumb\Breadcrumb
     */
    protected function getModel()
    {
        return $this->model;
    }
    
    /**
     * Obtiene un elemento del Breadcrumb.
     * 
     * @return Item
     */
    public function get($key)
    {
        return $this->getModel()->get($key);
    }
    
    /**
     * Obtiene la cantidad de items que contiene el Breadcrumb.
     * 
     * @return int Cantidad de items en el Breadcrumb.
     */    
    public function count()
    {
        return $this->getModel()->count();
    }

    public function getIterator() 
    {
        return $this->getModel()->getIterator();
    }
    
    public function getTrailFor(Item $item)
    {
        return $this->getModel()->getTrailFor($item);
    }
}
