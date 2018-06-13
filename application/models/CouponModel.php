<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CouponModel extends CI_Model {

  	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
				 
        } 
	
	private $Table = 'coupons';
	
	
	  
		
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
	
	
	public function UpdateProductByID($data,$product_id)
	{  
 
 		$res = $this->db->update($this->Table, $data ,['id' => $product_id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	public function TrashProductByID($product_id)
	{  
 
 		$res = $this->db->delete($this->Table,['id' => $product_id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	 public function DropDownCategory()
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Table);
		$this->db->where('parent_id','0');
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	
	 public function CategoryByIDList($parent_id)
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Table);
		$this->db->where('parent_id',$parent_id);
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	
	
  	
	
	 public function CatNameById($id) 
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Table);
		$this->db->where("id",$id);
		$this->db->limit(1);
  		$query = $this->db->get();
		$res = $query->row_array();
 	 	return $res['name'];
		  
   	}
 
 
 	 public function GetById($id) 
	{  
 		$this->db->select('*');
		$this->db->from($this->Table);
		$this->db->where("id",$id);
		$this->db->limit(1);
  		$query = $this->db->get();
		$res = $query->row_array();
 	 	return $res;
		  
   	}
 
 }
