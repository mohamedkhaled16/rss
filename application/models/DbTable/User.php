<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'user';

    function addUser($data){
        $row = $this->createRow();
        $row->id = $data['id'];
        $row->name = $data['name'];
        $row->username = $data['username'];
        $row->password = md5($data['password']);
        $row->email = $data['email'];
        $row->gender = $data['gender'];
        $row->country = $data['country'];
        $row->photo = $data['photo'];
        $row->signture = $data['signture'];
        //$row->status = $data['status'];
        //$row->role = $data['role'];
        return $row->save();
    }

    function listUsers(){

        return $this->fetchAll()->toArray();
    }

    function deleteUser($id){
        return $this->delete('id='.$id);
    }
   
    
     function banUser($id){
		$record = $this->find($id)->toArray();
		$status = $record['status'] ? 'Available' : 'Ban';
		$data = array("status" => $status);
		$where = "id = ".$id;
		return $this->update($data,$where);
	}
    function getUserById($id){
        return $this->find($id)->toArray();
    }



    function getUserByEmail($email){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=$db->select()
            ->from(array('p' => 'user'))
            ->where('p.email="'.$email.'"');
        return $select->query()->fetchAll();
    }

        function getUserByUsername($username){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=$db->select()
            ->from(array('p' => 'user'))
            ->where('p.username="'.$username.'"');
        return $select->query()->fetchAll();
    }


    function getUser($user){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=$db->select()
            ->from(array('p' => 'user'))
            ->where('p.email=?',$user)
            ->ORwhere('p.username=?',$user);
        return $select->query()->fetchAll();
    }






    public function editUser($data) {
        try {
            $row = $this->fetchRow("id=" . $data['id']);
            $row->id = $data['id'];
            $row->name = $data['name'];
            $row->username = $data['username'];
            if (!empty($data['password'])) {
                $row->password = md5($data['password']);
            }
            $row->email = $data['email'];
            $row->gender = $data['gender'];
            $row->country = $data['country'];
            $row->photo = $data['photo'];
            $row->signture = $data['signture'];
            $row->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

