<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;


class ViewStateController extends BaseController
{
    public function headersAction()
    {        
        return $this->render('BluegrassBluesBluesBundle:ViewState:headers.html.twig',
                array()
		);
    }    
}
