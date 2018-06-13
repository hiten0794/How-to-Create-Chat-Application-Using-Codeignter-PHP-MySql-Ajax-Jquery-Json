<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class BrandsModel extends CI_Model {
  	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
				 
        } 
	
	private $Table = 'brands';
	private $TableBrand = 'product_brands';
 
	  
 public function AllSlides() 
	{  
 		$this->db->select('id,title,description,url,image');
		$this->db->from($this->Table);
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
  		$res = $this->db->update($this->Table, ['status' => 0]  ,['id' => $id ] ); 
 		if($res == 1)
 			return true;
 		else
 			return false; 
  	}
	public function UnPublishByID($id)
  	{  
  		$res = $this->db->update($this->Table, ['status' => 1]  ,['id' => $id ] ); 
 		if($res == 1)
 			return true;
 		else
 			return false; 
  	}
	
		
	public function All() 
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Table);
    	$query = $this->db->get();
		return $query->result_array();
		
    }
	
	public function AddProduct($data)
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
	
	public function ShopCategoryBySlug($slug)
	{  
 		$this->db->select('id');
		$this->db->from($this->Table);
		$this->db->where('slug',$slug);
   		$query = $this->db->get();
		$res=$query->row_array();
 		return $res['id']; 
		 
   	}
	
/////////////////Product Brand Model Functions//////////////////////////////////////////////////////////////////////////
  
	public function AddProductBrand($data)
	{  
 		$res = $this->db->insert($this->TableBrand, $data ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	 
 	 public function GetBrandById($id) 
	{  
 		$this->db->select('*');
		$this->db->from($this->TableBrand);
		$this->db->where("id",$id);
		$this->db->limit(1);
  		$query = $this->db->get();
		$res = $query->row_array();
 	 	return $res;
		  
   	}
	
 	public function UpdateProductBrandByID($data,$product_id)
	{  
 
 		$res = $this->db->update($this->TableBrand, $data ,['id' => $product_id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	public function TrashProductBrandByID($product_id)
	{  
 
 		$res = $this->db->delete($this->TableBrand,['id' => $product_id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
 public function BrandsList() 
	{  
 		$this->db->select('id,name');
		$this->db->from($this->TableBrand);
		$this->db->where('status',1);
    	$query = $this->db->get();
		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
    }
 public function BrandByIDList($id) 
	{  
 		$this->db->select('id,name');
		$this->db->from($this->TableBrand);
		$this->db->where('status',1);
		$this->db->where('id',$id);
    	$query = $this->db->get();
		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
    }	
	
  public function GetBrands($ids)
	{  
	//print_r($ids); die;
 		$this->db->select('*');
		$this->db->from($this->TableBrand);
		$this->db->where_in('id',$ids);
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	
	public function BrandIdBySlug($slug)
	{  
 		$this->db->select('*');
		$this->db->from($this->TableBrand);
		$this->db->where_in('slug',$slug);
   		$query = $this->db->get();
		$res = $query->row_array();
	 	return $res['id'];
   	}
	
		
	public function Slug($name)
 
 		{
  			$count = 0;
 
 			$name = strtolower(url_title($name));

  			$slug_name = $name;             // Create temp name
 
 			while(true) 
 
 			{
 
 				$this->db->select('id');

 
				$this->db->where('slug', $slug_name);   // Test temp name
 				$query = $this->db->get($this->TableBrand);

 				if ($query->num_rows() == 0) break;
 				$slug_name = $name . '-' . (++$count);  // Recreate new temp name
  
			}

  			return $slug_name;      // Return temp name
 
	 }


	
	
 
 
 }
