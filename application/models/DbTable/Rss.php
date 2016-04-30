<?php

class Application_Model_DbTable_Rss extends Zend_Db_Table_Abstract
{

    protected $_name = 'rss';
	



    public function addAction($data)
    {
        $row = $this->createRow();
        $row->site_name = $data['site_name'];
        $row->site_description = $data['site_description'];
        $row->site_rss_url = $data['site_rss_url'];
        $row->user_id = $data['user_id'];
        return $row->save();
    }


    function listRss($uid){
       	$db = Zend_Db_Table::getDefaultAdapter();
        $select=$db->select()
            ->from(array('r' => 'rss'))
            ->where('r.user_id='.$uid);
        return $select->query()->fetchAll();
	}
	

	function getRssById($rssid){
		return $this->find($rssid)->toArray();
	}

    

	

    function getRssPerUser($uid,$rssid){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=$db->select()
            ->from(array('r' => 'rss'))
            ->where('r.user_id='.$uid.' And r.site_rss_url = '."'".$rssid."'");
        return $select->query()->fetchAll();
    }
    


	function deleteRss($rssid){
		return $this->delete('id='.$rssid);
	}






    public function editRss($data) {
        try {
            $row = $this->fetchRow("id=" . $data['id']);
            $row->id = $data['id'];
            $row->site_name = $data['site_name'];
            $row->site_rss_url = $data['site_rss_url'];
            $row->site_description = $data['site_description'];
            $row->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}

