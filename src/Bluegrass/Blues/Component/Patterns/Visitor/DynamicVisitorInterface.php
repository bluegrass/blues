<?php


namespace Bluegrass\Blues\Component\Patterns\Visitor;

/**
 * Definición de la interfaz que debe implementar un visitor dinámico.
 * Un visitor dinámico es una implementación del patrón de diseño "visitor" que
 * no está ligada a una serie de tipos estáticos, sino que los tipos posibles
 * a "visitar" se definen en el momento de instanciarse.
 * 
 * @author gcaseres
 */
interface DynamicVisitorInterface 
{    
    function visit($object);
}

