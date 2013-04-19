<?php

namespace Bluegrass\Blues\Component\Breadcrumb\Sitemap;

use Bluegrass\Blues\Component\Sitemap\NodeInterface;

/**
 * Interfaz que debe implementar un nodo de un sitemap capaz de cambiar
 * su etiqueta en función de un conjunto de parámetros.
 * Este tipo de nodos requieren que se invoque al método process para actualizar
 * la etiqueta.
 */
interface DynamicLabelNodeInterface extends NodeInterface
{
    /**
     * Procesa el nodo a partir de un conjunto de parámetros de manera que
     * contenga una etiqueta generada según los mismos.
     * 
     * @param array $parameters Arreglo de parámetros.
     */
    function process(array $parameters);
}
