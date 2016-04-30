<?php

class RssController extends Zend_Controller_Action
{


    private $auth=null;
    private $user=null;

    public function init()
    {
        $this->view->headTitle('Rss'); 
        $this->auth = Zend_Auth::getInstance();
        if($this->auth->hasIdentity()){
            $this->view->user=$this->auth->getIdentity();
            $this->user=$this->auth->getIdentity();
        }
            $this->model = new Application_Model_DbTable_Rss();
            if($this->auth->getIdentity()){}else{$this->redirect('user/login');
        }
    }


    public function checkURL($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {

            try {
                 $feed = Zend_Feed_Reader::import($url);  
                 
                //$feed = Zend_Feed::import($url);
            }
            catch(Exception $e)
            {
                //echo $e;
                //exit();
                return false;
            }
            return true;
        } else {
            return false;
        }


    }


    public function existBefore($rssid)
    {
$res = $this->model->getRssPerUser($this->user->id,$rssid);
//print_r($res);
//exit();
        if (empty($res))
        {return false;}
        else
        {return true;}
    }

    public function indexAction()
    {
        $this->redirect('rss/list');
    }

    public function addAction()
    {
        $data = $this->getRequest()->getParams();
        $form = new Application_Form_Rss();
        if($this->getRequest()->isPost())
        {
            if(! $this->existBefore($data['site_rss_url']))
                {$form->getElement("site_rss_url")->removeValidator('Db_NoRecordExists');}            
            $data['user_id']=$this->user->id;
            $data['id']=null;
            if($form->isValid($data) && $this->checkURL($data['site_rss_url']))
            {
                if ($this->model->addAction($data))
                {
                    $this->redirect('rss/index');
                }
            }
            else  if(!$this->checkURL($data['site_rss_url']))
            {
                $form->getElement("site_rss_url")->setErrors(array("It's Not aValid URL"));
            }   
        }

        $this->view->flag = 1;
        $this->view->form = $form;
        $this->render('add');
    }

    public function editAction()
    {
         $rss_id = $this->getRequest()->getParam('rssid');
         $this->checkOwner($rss_id);
         $form = new Application_Form_Rss($rss_id);
            if(!$this->_request->isPost() && $rss_id)
            {                
                
                $rss_Data = $this->model->getRssById($rss_id);            
                $form->populate($rss_Data[0]);
                $this->view->form = $form;
                $this->render('add');

            }
            else
            {   

            $data = $this->_request->getParams();
            $old = $this->model->getRssById($rss_id);
        
            if($old[0]['site_rss_url'] == $data['site_rss_url'])
                {$form->getElement("site_rss_url")->removeValidator('Db_NoRecordExists');}            
            $data['user_id']=$this->user->id;
            $data['id']=$rss_id;

            if($form->isValid($data) && $this->checkURL($data['site_rss_url']))
            {
                echo $this->model->editRss($data);
                if ($this->model->editRss($data))
                {
                    echo $this->model->editRss($data);
                    $this->redirect('rss/index');
                }
            }
            else if(!$this->checkURL($data['site_rss_url']))
            {
                $form->getElement("site_rss_url")->setErrors(array("It's Not aValid URL"));
            } 
$this->view->flag = 1;
        $this->view->form = $form;
        $this->render('add');
            }   
    }

public function checkOwner($rss_id)
    {

        $rss_Data = $this->model->getRssById($rss_id); 

        if($rss_Data[0]['user_id'] != $this->user->id)
        {
            $this->redirect('rss/'); 
        }
    }


    public function deleteAction()
    {
       $rss_id = $this->getRequest()->getParam('rssid');
        if($rss_id){
            checkOwner($rss_id);
            if ($this->model->deleteRss($rss_id))
               $this->redirect('rss/');        
                } else {
                $this->redirect('rss/');
                    }
    }

    public function viewAction()
    {

   $rss_id = $this->getRequest()->getParam('rssid');
        if(! empty($rss_id)){
            $this->checkOwner($rss_id);
        }
        else
        {
                            $this->redirect('rss/');

        }
        $old = $this->model->getRssById($rss_id);
        $this->view->rsstitle=$old[0]['site_name'];
        $this->view->rssdesc=$old[0]['site_description'];
        echo '<meta charset="UTF-8">';
        $feed = Zend_Feed_Reader::import($old[0]['site_rss_url']); 


        foreach ($feed as $entry) {


                    $edata = array(
                        'id' => $entry->getId(),
                        'title'        => $entry->getTitle(),
                        'description'  => $entry->getDescription(),
                        'dateModified' => $entry->getDateModified(),
                        'authors'       => $entry->getAuthors(),
                        'link'         => $entry->getLink(),
                       // 'image'         => $entry->getImage(),
                        'content'      => $entry->getContent()
                    );
                    $data['entries'][] = $edata;

                                }
//print_r($feed);
  //                              exit();
                                
    $this->view->rssdata=$data;
       
 
                
    }

    public function listAction()
    {
        $uid=$this->user->id;
        $this->view->rss = $this->model->listRss($uid);
    }




public function rssAction()
    {

/*   $frontendOptions = array(
       'lifetime' => 7200,
       'automatic_serialization' => true
    );
    $backendOptions = array('cache_dir' => './tmp/');
    $cache = Zend_Cache::factory(
        'Core', 'File', $frontendOptions, $backendOptions
    );
     
    Zend_Feed_Reader::setCache($cache);*/
    $feed = Zend_Feed_Reader::import('http://www.planet-php.net/rdf/');
    $data = array(
        'title'        => $feed->getTitle(),
        'link'         => $feed->getLink(),
        'dateModified' => $feed->getDateModified(),
        'description'  => $feed->getDescription(),
        'language'     => $feed->getLanguage(),
        'entries'      => array(),
    );
     
    foreach ($feed as $entry) {
        $edata = array(
            'title'        => $entry->getTitle(),
            'description'  => $entry->getDescription(),
            'dateModified' => $entry->getDateModified(),
            'authors'       => $entry->getAuthors(),
            'link'         => $entry->getLink(),
            'content'      => $entry->getContent()
        );
        $data['entries'][] = $edata;
    }
    exit();
    }




}











