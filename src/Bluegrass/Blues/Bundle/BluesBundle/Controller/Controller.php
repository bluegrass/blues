<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Controller;

use Bluegrass\Blues\Bundle\BreadcrumbBundle\Model\Item;
use Bluegrass\Blues\Bundle\BreadcrumbBundle\Model\Breadcrumb;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\View\ViewState;
use Bluegrass\Blues\Component\Model\Web\Location\WebLocation;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;


class Controller extends BaseController
{
    private $_viewState = null;
    private $_breadcrumb = null;
    
    public function getDefaultViewParams()
    {
        return array( 'viewState' => $this->getViewState()->createView() );
    }     

    /**
     * @return Breadcrumb 
     */    
    public function getBreadcrumb(){
        
        if( is_null($this->_breadcrumb)  ){

            $viewState = $this->getViewState();
        
            $this->_breadcrumb = $this->get('bluegrass_breadcrumb');   
            $this->_breadcrumb -> load( $viewState );
            
        }
        return $this->_breadcrumb;
    }
    
    function addBreadcrumbItem( $title, WebLocation $webLocation ){

        $bc = $this->getBreadcrumb()->add(  new Item( $title, $webLocation ) );
    }
    
    /**
     * Renders a view.
     *
     * @param string   $view The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response A response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {        
        $parameters = array_merge( $parameters, $this->getDefaultViewParams() );
        return parent::render($view, $parameters, $response);
    }    
    
    /**
     * Obtiene el View State inicializados con los valores del request
     * @return ViewState 
     */
    
    public function getViewState()
    {
        if(is_null($this->_viewState) ){
            $this->_viewState = ViewState::createFromGlobals($this->getRequest(), $this->get('session'));
        }
        return $this->_viewState;
    }    
    
    public function internalRedirect( WebLocation $webLocation, $status = 302)
    {
        $uniqid = uniqid();
        
        $webLocation->setParameters( array_merge( $webLocation->getParameters(), array( ViewState::REQUEST_PARAM_NAME => $uniqid ) ) );
        
        $this->get('session')->set($uniqid, $this->getViewState()->getData() );
        
        $url = "TO-DO"; // $this->generateUrl($routeData['route'], $params)
        return parent::redirect( $url , $status);
    }    
}
