<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->redirect('user/login');
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }




}



