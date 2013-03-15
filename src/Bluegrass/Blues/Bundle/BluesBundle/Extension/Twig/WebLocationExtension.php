<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Extension\Twig;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\WebLocation;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface;

class WebLocationExtension extends \Twig_Extension
{
    private $environment;
    private $urlGenerator;
    
    protected function setUrlGenerator(UrlGeneratorInterface $value)
    {
        $this->urlGenerator = $value;
    }
    
    protected function getUrlGenerator()
    {
        return $this->urlGenerator;
    }
    
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->setUrlGenerator($urlGenerator);
    }
    
    public function getName()
    {
        return 'weblocation';
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        return array(
            'weblocation_path' => new \Twig_Function_Method($this, 'getPath', array('is_safe' => array('html'))),
            'weblocation_url' => new \Twig_Function_Method($this, 'getUrl', array('is_safe' => array('html')))
        );
    }

    public function getPath(WebLocation $location, $relative = false)
    {       
        return $this->getUrlGenerator()->generate($location, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
    }    

    public function getUrl(WebLocation $location, $schemeRelative = false)
    {       
        return $this->getUrlGenerator()->generate($location, $schemeRelative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL);
    }    
    
}
