<?php
Zend_Layout::startMvc();

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initSession()
    {
        Zend_Session::start();
        //$session = new Zend_Session_Namespace('user');
        //$session->setExpirationSeconds(1800);
    }
}

