<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LoginWith_Model extends CI_Model{
	function __construct() {
		$this->tableName = 'users';
		$this->primaryKey = 'id';
	}
 
	
	
	
		public function InsertFBUser($data = array()){
			$this->db->select($this->primaryKey);
			$this->db->from($this->tableName);
			//$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'AuthKey_Facebook'=>$data['AuthKey_Facebook']));
			$this->db->where(array('AuthKey_Facebook'=>$data['AuthKey_Facebook']));
			$prevQuery = $this->db->get();
			$prevCheck = $prevQuery->num_rows();
			
			if($prevCheck > 0){
				$prevResult = $prevQuery->row_array();
				$data['modified'] = date("Y-m-d H:i:s");
				
				$dataUpdate = array('AuthKey_Facebook' => $data['AuthKey_Facebook']);
				
				$update = $this->db->update($this->tableName,$dataUpdate,array('id'=>$prevResult['id']));
				$userID = $prevResult['id'];
			}else{
				$data['created'] = date("Y-m-d H:i:s");
				$data['modified'] = date("Y-m-d H:i:s");
				$insert = $this->db->insert($this->tableName,$data);
				$userID = $this->db->insert_id();
			}
	
			return $userID?$userID:FALSE;
    }
	
		public function InsertGoogleUser($data = array()){
			$this->db->select($this->primaryKey);
			$this->db->from($this->tableName);
			//$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'AuthKey_Facebook'=>$data['AuthKey_Facebook']));
			$this->db->where(array('AuthKey_Google'=>$data['AuthKey_Google']));
			$prevQuery = $this->db->get();
			$prevCheck = $prevQuery->num_rows();
			
			if($prevCheck > 0){
				$prevResult = $prevQuery->row_array();
				$data['modified'] = date("Y-m-d H:i:s");
				
				$dataUpdate = array('AuthKey_Google' => $data['AuthKey_Google']);
				
				$update = $this->db->update($this->tableName,$dataUpdate,array('id'=>$prevResult['id']));
				$userID = $prevResult['id'];
			}else{
				$data['created'] = date("Y-m-d H:i:s");
				$data['modified'] = date("Y-m-d H:i:s");
				$insert = $this->db->insert($this->tableName,$data);
				$userID = $this->db->insert_id();
			}
	
			return $userID?$userID:FALSE;
    }



		public function TwitterFollow($data = array()){
			$this->db->select('*');
			$this->db->from('subscriptions');
 			$this->db->where(array('subscriber_id'=>$data['subscriber_id']));
			$prevQuery = $this->db->get();
			$prevCheck = $prevQuery->num_rows();
			
			if($prevCheck > 0){
				$prevResult = $prevQuery->row_array();
				//$data['modified'] = date("Y-m-d H:i:s");
				
				$dataUpdate = array('subscriber_id' => $data['subscriber_id']);
				
				$update = $this->db->update('subscriptions',$dataUpdate,array('id'=>$prevResult['id']));
				$userID = $prevResult['id'];
			}else{
				//$data['created'] = date("Y-m-d H:i:s");
				//$data['modified'] = date("Y-m-d H:i:s");
				$insert = $this->db->insert('subscriptions',$data);
				$userID = $this->db->insert_id();
			}
	
			return $userID?$userID:FALSE;
    }
	
	
	
		
	
}
