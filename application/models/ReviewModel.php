<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReviewModel extends CI_Model {

  	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
				 
        } 
	
	private $Table = 'reviews';
	
 	public function All() 
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Table);
    	$query = $this->db->get();
		return $query->result_array();
     }
	
	public function Add($data)
	{  
 		$res = $this->db->insert($this->Table, $data ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
  
	
	public function TrashByID($id)
	{  
 
 		$res = $this->db->delete($this->Table,['id' => $id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	   
 
 
 
 	 public function GetProductReviewById($p_id) 
	{  
 		$this->db->select('*');
		$this->db->from($this->Table);
		$this->db->where("p_id",$p_id);
   		$query = $this->db->get();
		$res = $query->result_array();
 	 	return $res;
		  
   	}
	
	public function GetProductReviewCountById($p_id) 
	{  
 		$this->db->select('*');
		$this->db->from($this->Table);
		$this->db->where("p_id",$p_id);
   		$query = $this->db->get();
		$res = $query->num_rows();
 	 	return $res;
		  
   	}
	
 
	
  
	
	
	
 
 
 }
