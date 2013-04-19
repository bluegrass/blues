<?php

namespace Bluegrass\Blues\Component\Patterns\Visitor;

use ArrayObject;
use Bluegrass\Blues\Component\Patterns\Visitor\DynamicVisitorInterface;
use ReflectionClass;
use ReflectionMethod;

/**
 * Implementación abstracta del patrón visitor en su versión dinámica.
 * Esta implementación contiene el comportamiento necesario para poder registrar
 * manejadores (métodos) para cada posible tipo a visitar.
 *
 * @author gcaseres
 */
abstract class AbstractDynamicVisitor implements DynamicVisitorInterface
{
    private $handlers;
    
    protected function __construct()
    {
        $this->setHandlers(new ArrayObject());
    }
    
    
    private function setHandlers(ArrayObject $value)
    {
        $this->handlers = $value;
    }
    
    private function getHandlers()
    {
        return $this->handlers;
    }
    
    public function visit($object)
    {
        $class = new ReflectionClass($object);
        
        $method = $this->getNearestMatchHandler($class);
        
        
        $method->invoke($this, $object);        
    }

    /**
     * Obtiene la coincidencia mas cercana de una clase con alguna de las
     * registradas en el visitor.
     * 
     * La cercanía de una clase con otra esta definida en términos del árbol
     * de jerarquía de clases.
     * 
     * @param ReflectionClass $searchClass
     * @return ReflectionMethod Manejador para la clase especificada.
     * @throws \Exception Si no se encontró una coincidencia.
     */
    private function getNearestMatchHandler($searchClass)
    {
        //Obtener todas las clases registradas.
        $classes = array_keys($this->getHandlers()->getArrayCopy());
        
        /* 
         * Seleccionar aquellas clases de las cuales extienda la especificada
         * a buscar.
         */
        $elegibleClasses = array();
        foreach ($classes as $class) {
            if ($searchClass->isSubclassOf($class)) {
                $elegibleClasses[] = $class;
            }
        }
                    
        /*
         * Buscar la coincidencia mas cercana a partir de las clases
         * seleccionadas.
         * 
         * Básicamente se busca entre las seleccionadas una clase que sea 
         * subclase de todas las demás.
         */
        foreach ($elegibleClasses as $currentClass) {
            $found = true;
            $currentClass = new ReflectionClass($currentClass);

            foreach ($elegibleClasses as $class) {
                $found = $found && ($currentClass->isSubclassOf($class) || ($currentClass->getName() == $class));
            }
            
            if ($found) {                
                return $this->getHandlers()->offsetGet($currentClass->getName());
            } else {
                throw new \Exception("Este visitor no contiene un manejador para " . $searchClass->getName());
            }
        }
    }
    
    /**
     * Especifica el método que se ejecutará cuando se "visite" una instancia
     * de una clase en particular.
     * 
     * @param ReflectionClass $class Clase que debe implementar una instancia
     * visitada para ejecutar el método.
     * @param ReflectionMethod $method Método que se ejecutará.
     */
    protected function setVisitHandler(ReflectionClass $class, ReflectionMethod $method)
    {
        $this->getHandlers()->offsetSet($class->getName(), $method);
    }
}
