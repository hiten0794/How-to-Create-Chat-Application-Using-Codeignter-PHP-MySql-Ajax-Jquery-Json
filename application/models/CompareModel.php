<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CompareModel extends CI_Model {
  	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }
  	private $Compare = 'compare';
	public function AddToCompare($p_id){
		
		$guest_user_id; 
		
		if(isset($this->session->userdata['User']['role']) != ''){
			$guest_user_id = $this->session->userdata['User']['id'];
		}else{
		
			if($this->session->userdata('guest_user_id') != ''){
				$guest_user_id=$this->session->userdata('guest_user_id');
			}else{
				$guest_user_id=$this->GuestUserSeesion();
  			}
		}
  	  
		$condition=['guest_user_id'=>$guest_user_id, 'p_id' => $p_id];
		
		$this->db->select('*');
		$this->db->from($this->Compare);
		$this->db->where($condition);
   		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
 		if($prevCheck > 0){
 			 //echo 'update cart row';
			 return true;
		 } else {
 			$res = $this->db->insert($this->Compare, ['guest_user_id'=>$guest_user_id, 'p_id' => $p_id] );
			if($res == 1){
				return true;//$this->GetCartItems();
			}else
				return false;
		 }
		 
 	}
	public function GetCompareItems(){
		
		$guest_user_id;
		if(isset($this->session->userdata['User']['role']) != ''){
			$guest_user_id = $this->session->userdata['User']['id'];
		}else{
			$guest_user_id = $this->session->userdata('guest_user_id');
 		}
		
		
		$this->db->select('*');
		$this->db->from($this->Compare);
		$this->db->where('guest_user_id',$guest_user_id);
		$q = $this->db->get();
 		
			if($q ){
 				return $q->result_array();
 			}else
 				return false;
	}
	
	public function GuestUserSeesion(){
		
 		$this->db->select_max('id');
		$this->db->from($this->Compare);
		$query = $this->db->get();
		$res = $query->row_array();
		$guest_user_id = $res['id'];
		if(empty($guest_user_id)){$guest_user_id=rand(10,1000);}
		
 		$this->session->set_userdata('guest_user_id',$guest_user_id);
		return $this->session->userdata('guest_user_id');
	}
	
	public function GetGuestUserDataLoginTime($guest_user_id){
		$this->db->select('*');
		$this->db->from($this->Compare);
		$this->db->where('guest_user_id',$guest_user_id);
		$q = $this->db->get();
 		if($q ){
 			return $q->result_array();
 		}else
 			return false;
	
	}
	public function UpdateGuestUserDataLoginSuccess($guest_user_id,$current_user_login_id)
	{  
 		$res = $this->db->update($this->Compare,['guest_user_id' => $current_user_login_id],['guest_user_id' => $guest_user_id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	public function TrashCartItemsAfterAddOrder(){
		
		$guest_user_id;
		if(isset($this->session->userdata['User']['role']) != ''){
			$guest_user_id = $this->session->userdata['User']['id'];
		}else{
			$guest_user_id = $this->session->userdata('guest_user_id');
 		}
		
 		$res = $this->db->delete($this->Compare,['guest_user_id' => $guest_user_id ] ); 
 		if($res == 1)
 			return true;
 		else
 			return false;
			
 	}
	
	public function TrashCompareProduct($id){
 
  		$res = $this->db->delete($this->Compare,['id' => $id ] ); 
 		if($res == 1)
 			return true;
 		else
 			return false;
			
 	}
	
	
  
	
	
 }
