<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SliderModel extends CI_Model {

  	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
				 
        } 
	
	private $Category = 'slider';
	
 
	  
 public function AllSlides() 
	{  
 		$this->db->select('id,title,description,url,image');
		$this->db->from($this->Category);
		$this->db->where('status',1);
    	$query = $this->db->get();
		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
    }
	    
	public function PublishByID($id)
  	{  
  		$res = $this->db->update($this->Category, ['status' => 0]  ,['id' => $id ] ); 
 		if($res == 1)
 			return true;
 		else
 			return false; 
  	}
	public function UnPublishByID($id)
  	{  
  		$res = $this->db->update($this->Category, ['status' => 1]  ,['id' => $id ] ); 
 		if($res == 1)
 			return true;
 		else
 			return false; 
  	}
	
		
	public function All() 
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Category);
    	$query = $this->db->get();
		return $query->result_array();
		
    }
	
	public function AddProduct($data)
	{  
 		$res = $this->db->insert($this->Category, $data ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	
	public function UpdateProductByID($data,$product_id)
	{  
 
 		$res = $this->db->update($this->Category, $data ,['id' => $product_id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	public function TrashProductByID($product_id)
	{  
 
 		$res = $this->db->delete($this->Category,['id' => $product_id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	   
	
  	
	
	 public function CatNameById($id) 
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Category);
		$this->db->where("id",$id);
		$this->db->limit(1);
  		$query = $this->db->get();
		$res = $query->row_array();
 	 	return $res['name'];
		  
   	}
 
 
 	 public function GetById($id) 
	{  
 		$this->db->select('*');
		$this->db->from($this->Category);
		$this->db->where("id",$id);
		$this->db->limit(1);
  		$query = $this->db->get();
		$res = $query->row_array();
 	 	return $res;
		  
   	}
	
	public function ShopCategoryBySlug($slug)
	{  
 		$this->db->select('id');
		$this->db->from($this->Category);
		$this->db->where('slug',$slug);
   		$query = $this->db->get();
		$res=$query->row_array();
 		return $res['id']; 
		 
   	}
	
  
	
	
	
 
 
 }
