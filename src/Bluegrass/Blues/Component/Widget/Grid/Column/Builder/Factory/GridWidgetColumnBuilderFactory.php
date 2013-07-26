<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Column\Builder\Factory;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

use Bluegrass\Blues\Component\Widget\Grid\View\Column\GridWidgetColumnViewModelBuilderInterface;

/**
 *
 * @author ldelia
 */
class GridWidgetColumnBuilderFactory implements GridWidgetColumnBuilderFactoryInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;    
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }    
    
    /**
     * 
     * @param string $id
     * @return GridWidgetColumnViewModelBuilderInterface
     */
    public function getBuilder( $id )
    {
        $columnViewModelBuilderID = 'bluegrass.widget.grid.column.'.$id.'.builder';
        
        try {
            $columnViewModelBuilder = $this->container->get( $columnViewModelBuilderID );    
            return $columnViewModelBuilder;
        }catch( ServiceNotFoundException $e ){
            throw new \Exception("El tipo de columna '$id' no es conocido por el GridWidgetColumnBuilderFactory");
        }
                
    }
}

