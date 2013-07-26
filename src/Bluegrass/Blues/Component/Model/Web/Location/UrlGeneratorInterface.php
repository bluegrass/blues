<?php

namespace Bluegrass\Blues\Component\Model\Web\Location;

interface UrlGeneratorInterface 
{
    /**
     * Generates an absolute URL, e.g. "http://example.com/dir/file".
     */
    const ABSOLUTE_URL = true;

    /**
     * Generates an absolute path, e.g. "/dir/file".
     */
    const ABSOLUTE_PATH = false;

    /**
     * Generates a relative path based on the current request path, e.g. "../parent-file".
     * @see UrlGenerator::getRelativePath()
     */
    const RELATIVE_PATH = 'relative';

    /**
     * Generates a network path, e.g. "//example.com/dir/file".
     * Such reference reuses the current scheme but specifies the host.
     */
    const NETWORK_PATH = 'network';

    
    /**
     * Devuelve la URL representada por la WebLocation
     * 
     * @param \Bluegrass\Blues\Component\Model\Web\Location\WebLocation $location Localización WEB.
     * @param Boolean|string $referenceType El tipo de referencia a ser generado (absoluto, network o relativo)
     * 
     * @throws RouteNotFoundException              If the named route doesn't exist
     * @throws MissingMandatoryParametersException When some parameters are missing that are mandatory for the route
     * @throws InvalidParameterException           When a parameter value for a placeholder is not correct because
     *                                             it does not match the requirement

     * @return string La URL generada
     */
    public function generate(WebLocation $location, $referenceType = self::ABSOLUTE_PATH);
    
    public function generateFromUrlBasedLocation(UrlBasedLocation $location);
    public function generateFromRouteBasedLocation(RouteBasedLocation $location, $referenceType = self::ABSOLUTE_PATH);
}
