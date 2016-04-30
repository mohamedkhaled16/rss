<?php

class UserController extends Zend_Controller_Action
{

    private $model = null;

    private $aut = null;

    private $auth = null;
    private $userData = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->auth = Zend_Auth::getInstance();
        if($this->auth->hasIdentity()){
            $this->view->user=$this->auth->getIdentity();
        }
        $this->model = new Application_Model_DbTable_User();


   
        if(($action = $this->getRequest()->getActionName() != "login") &&  !$this->auth->hasIdentity() && $action = $this->getRequest()->getActionName() != "add")
        {
$this->redirect('user/login');
        }


else if ($action = $this->getRequest()->getActionName() != "login") {
    # code...
}{

    $this->userData = $this->auth->getIdentity();
}

    }

    public function indexAction()
    {
        // action body
        if($this->userData->role == "Admin"){
        $this->view->users = $this->model->listUsers();
    }
    else{
$this->redirect('rss/list');

    }
    }

    public function addAction()
    {
        // action body
        $data = $this->getRequest()->getParams();
        $form = new Application_Form_User();
               
        //exit();
        if ($this->getRequest()->isPost()) {


            if ($form->isValid($data)) {
                if ($data['password'] === $data['cpassword']) {
                    $upload = new Zend_File_Transfer_Adapter_Http();
                    $upload->addValidator('Size', false, 52428800, 'image');
                    $upload->setDestination(PUBLIC_PATH . '/uploads');
                    $originalFilename = pathinfo($upload->getFileName());
                    $newName = time() . "." . $originalFilename['extension'];
                    //$newName = time().str_replace(PUBLIC_PATH . '/uploads/',"",$upload->getFileName());
                    $data['photo'] = $newName;
                    
                    $upload->addFilter('Rename', PUBLIC_PATH . '/uploads/'.$newName);
                    $files = $upload->getFileInfo();
                    foreach ($files as $file => $info) {
                        if ($upload->isValid($file)) {
                            $upload->receive($file);
                        }
                    }
                    if ($this->model->addUser($data))
                    {
                    include PUBLIC_PATH . '/../library/sendgrid-php/sendgrid-php.php';
                    $sendgrid = new SendGrid("");
                    $email = new SendGrid\Email();
                    $email
                            ->addTo($data["email"])
                            ->setFrom('admin@zrss.com')
                            ->setSubject('Welcome to RSS')
                            ->setText('Your Registeration Info')
                            ->setHtml("Dear Mr." . $data['name'] . "<br/>&nbsp;&nbsp;&nbsp;Thanks for registeration.<br/>your username: " . $data['username'] . "<br/>your password: " . $data['password'] . "<br/>your password: ");
                      try {
                        $sendgrid->send($email);
                    }
                    catch (Exception $ex) {
                        $hhhhh="dsadsa";

                    }


                        $this->redirect('user/index');
                    }
                }
            }
        }

        $this->view->flag = 1;
        $this->view->form = $form;
        $this->render('add');

    }

    public function deleteAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            if ($this->model->deleteUser($id))
                $this->redirect('user/index');

        } else {
            $this->redirect('user/index');
        }

    }

    public function editAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
        $form = new Application_Form_User();
        $user = $this->model->getUserById($id);
        $form->populate($user[0]);
        $form->setAction('../../add');
        $this->view->form = $form;
        $this->render('add');
    }

    public function loginAction()
    {
        if ($this->_request->getParam('username')) {
            $username = $this->_request->getParam('username');
            $password = $this->_request->getParam('password');
            $db = Zend_Db_Table::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'user', 'email', 'password');
            $authAdapter->setIdentity($username);
            $authAdapter->setCredential(md5($password));
            $result = $authAdapter->authenticate();
            if ($result->isValid()) {
                 $storage = $this->auth->getStorage();
                 $storage->write($authAdapter->getResultRowObject());

                $session=new Zend_Session_Namespace('user');

                $session->user=$this->model->getUser($username);
      
                if($this->auth->getIdentity()->role == 'Admin'){ $this->redirect('user/index');}else{ $this->redirect('rss/list');}
             

            } else {
                echo "auth fail";

            }

        } else {
        }
        // action body

    }

    public function profileAction()
    {
        // action body
    }

    public function logoutAction()
    {
        // action body
        $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->redirect('user/login');
    }

    public function banAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            if ($this->model->banUser($id))
                $this->redirect('user/index');

        } else {
            $this->redirect('user/index');
        }

    }

    public function editprofileAction()
    {
        $id = $this->userData->id;
        $form = new Application_Form_User();
if ($this->getRequest()->isPost()) {
    
     $data = $this->getRequest()->getParams();
    // echo $form->isValidPartial($data);
    //exit();
     //if((empty($this->model->getUserByEmail($data['email']))&&empty($this->model->getUserByUsername($data['username']))) || ($data['email']==$this->userData->email || $data['username']==$this->userData->username))
if($data['email']==$this->userData->email)
    {$form->getElement("email")->removeValidator('Db_NoRecordExists');}
if($data['username']==$this->userData->username)  
    {$form->getElement("username")->removeValidator('Db_NoRecordExists');}
            if ($form->isValidPartial($data)) {
               

                    $upload = new Zend_File_Transfer_Adapter_Http();
                    $upload->addValidator('Size', false, 52428800, 'image');
                    $upload->setDestination(PUBLIC_PATH . '/uploads');
                    $originalFilename = pathinfo($upload->getFileName());
                    $newName = time() . "." . $originalFilename['extension'];
                    //$newName = time().str_replace(PUBLIC_PATH . '/uploads/',"",$upload->getFileName());
                    $data['photo'] = $newName;
                    
                    $upload->addFilter('Rename', PUBLIC_PATH . '/uploads/'.$newName);
                    $files = $upload->getFileInfo();
                    echo $upload->getFileName();

if(!empty($upload->getFileName()))
{
                    foreach ($files as $file => $info) {
                        if ($upload->isValid($file)) {
                            $upload->receive($file);
                            unlink(PUBLIC_PATH . "/uploads/" . $this->userData->photo);
                            
                        }
                    }

}
else
{
 $data['photo'] =   $this->userData->photo;
}
   
   
$data['id'] = $this->userData->id;
 //exit($data['id']);

                    if ($this->model->editUser($data))
                    {
                       // $newObj[0] = $this->model->getUserById($data['id']);
                        //exit();
                //$this->userData=$newObj[0];
$session=new Zend_Session_Namespace('user');
$storage = $this->auth->getStorage();
$newObj = $this->model->getUserById($data['id']);
$session->user=$newObj;
$newObj=(object)$newObj[0];
$storage->write($newObj);

$this->redirect('user/index');
                    }

}
}





        $user = $this->model->getUserById($id);
        $form->populate($user[0]);
        $form->setAction('../../editprofile');
        $this->view->form = $form;
        $this->render('editprofile');
    }


}

















