<?php

namespace Bluegrass\Blues\Component\Menu;

use Knp\Menu\MenuFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Factory able to use the Symfony2 Routing component to build the url
 */
class RouterAwareFactory extends MenuFactory
{
    protected $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function createItem($name, array $options = array())
    {
        $generateUrl = isset($options['generateUrl'])?$options['generateUrl']:true;
        
        if (!empty($options['route'])) {
            $params = isset($options['routeParameters']) ? $options['routeParameters'] : array();
            $absolute = isset($options['routeAbsolute']) ? $options['routeAbsolute'] : false;
            
            if ($generateUrl)
                $options['uri'] = $this->generator->generate($options['route'], $params, $absolute);

            $options['extras'] = array_merge(
                array(
                    'route' => $options['route'],
                    'routeParameters' => $params
                ),
                isset($options['extras'])?$options['extras']:array()
            );                                
        }
                       
        return parent::createItem($name, $options);
    }
}
