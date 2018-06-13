<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class WishlistModel extends CI_Model {
  	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }
  	private $Wishlist='wishlist';
	public function AddToWishlist($p_id){
		
 
		$condition=['user_id'=> $this->session->userdata['User']['id'], 'p_id' => $p_id];
		
		$this->db->select('*');
		$this->db->from($this->Wishlist);
		$this->db->where($condition);
   		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
 		if($prevCheck > 0){
 			 //echo 'update cart row';
			 return true;// $this->GetWishlistItems();
		 } else {
 			$res = $this->db->insert($this->Wishlist, ['user_id'=>$this->session->userdata['User']['id'], 'p_id' => $p_id] );
			if($res == 1){
				return true; //$this->GetWishlistItems();
			}else
				return false;
		 }
		 
 	}
	public function GetWishlistItems(){
		$user_id=0;
		if(isset($this->session->userdata['User']['id'])){$user_id=$this->session->userdata['User']['id'];}
		$this->db->select('*');
		$this->db->from($this->Wishlist);
		$this->db->where('user_id',$user_id);
		$q = $this->db->get();
		return $q->result_array();
	}
 	public function RemoveItem($id)
	{  
 
 		$res = $this->db->delete($this->Wishlist,['id' => $id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	public function CheckIfExistsWishlist($product_id){
	
		if(isset($this->session->userdata['User']['id'])){
			$condition=['user_id'=> $this->session->userdata['User']['id'], 'p_id' => $product_id];
			
			$this->db->select('id');
			$this->db->from($this->Wishlist);
			$this->db->where($condition); 
			$q = $this->db->get();
			$prevCheck = $q->num_rows();
			if($prevCheck > 0){
				return 'active-wishlist';
			}else{
				return '';
			}
		}else{
			return '';
		}
		
	}
  
	
	
 }
