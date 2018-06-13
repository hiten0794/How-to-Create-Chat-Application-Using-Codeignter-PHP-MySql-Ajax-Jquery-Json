<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CategoryModel extends CI_Model {
  	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
				 
        } 
	
	private $Category = 'categories';
	
	
	public function HomepageCategories() 
	{  
 		$this->db->select('id,name,slug');
		$this->db->from($this->Category);
		$this->db->where('parent_id','0');
		$this->db->where('status','1');
    	$query = $this->db->get();
		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
    }
	public function HomepageSubCategories($id) 
	{  
 		$this->db->select('id,name,slug');
		$this->db->from($this->Category);
		$this->db->where('parent_id',$id);
		$this->db->where('status','1');
    	$query = $this->db->get();
		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
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
				$query = $this->db->get($this->Category);
				if ($query->num_rows() == 0) break;
				$slug_name = $name . '-' . (++$count);  // Recreate new temp name
			}
 			return $slug_name;      // Return temp name
	}
	
	public function CategoryBlockByVendorID($user_id)
  	{  
  		$res = $this->db->update($this->Category, ['status' => 0]  ,['user_id' => $user_id ] ); 
 		if($res == 1)
 			return true;
 		else
 			return false; 
  	}
	public function CategoryUnBlockByVendorID($user_id)
  	{  
  		$res = $this->db->update($this->Category, ['status' => 1]  ,['user_id' => $user_id ] ); 
 		if($res == 1)
 			return true;
 		else
 			return false;
  	}
	public function CategoryBlockByCateID($id)
  	{  
  		$res = $this->db->update($this->Category, ['status' => 0]  ,['id' => $id ] ); 
 		if($res == 1)
 			return true;
 		else
 			return false; 
  	}
	public function CategoryUnBlockByCateID($id)
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
	
	 public function DropDownCategory()
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Category);
		$this->db->where('parent_id','0');
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	
	 public function GetAdminCategory()
	{  
 		$this->db->select('id,name,slug,image,status');
		$this->db->from($this->Category);
		$this->db->where('parent_id','0');
		$this->db->where('status','1');
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	
	 public function GetBySubCatLisr($cate_id)
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Category);
		$this->db->where('parent_id',$cate_id);
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
		$this->db->from($this->Category);
		$this->db->where('parent_id',$parent_id);
		if($this->session->userdata['Admin']['role'] == 'Vendor'){
		$this->db->where('status',1);
		}
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
		$this->db->from($this->Category);
		$this->db->where("id",$id);
		$this->db->limit(1);
  		$query = $this->db->get();
		$res = $query->row_array();
 	 	return $res['name'];
		  
   	}
	
	 public function BrandIdGetBycateId($id) 
	{  
 		$this->db->select('id,name,brand_id');
		$this->db->from($this->Category);
		$this->db->where("id",$id);
		$this->db->limit(1);
  		$query = $this->db->get();
		$res = $query->row_array();
 	 	return $res['brand_id'];
		  
   	}
	
	 public function CateIdBySlug($slug) 
	{  
 		$this->db->select('id,name');
		$this->db->from($this->Category);
		$this->db->where("slug",$slug);
		$this->db->limit(1);
  		$query = $this->db->get();
		$res = $query->row_array();
 	 	return $res['id'];
		  
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
	
	 public function GetMainCategories()
	{  
 		$this->db->select('id,name,slug');
		$this->db->from($this->Category);
		$this->db->where('parent_id','0');
		$this->db->where('status','1');
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	public function GetSubCategories($id)
	{  
 		$this->db->select('id,name,slug,brand_id');
		$this->db->from($this->Category);
		$this->db->where('parent_id',$id);
		$this->db->where('status','1');
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	
	public function GetMainCategoriesByVendor($id)
	{  
 		$this->db->select('id,name,slug,brand_id');
		$this->db->from($this->Category);
		$this->db->where('user_id',$id);
		$this->db->where('status','1');
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	
	public function GetSubCategorieBySlug($slug)
	{  
 		$this->db->select('id,name,slug,brand_id');
		$this->db->from($this->Category);
		$this->db->where('slug',$slug);
		$this->db->where('status','1');
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	
	public function SearchCategories($q)
	{  
 		$this->db->select('*');
		$this->db->from($this->Category);
		$this->db->where('status','1');
		$this->db->like('name',$q);
   		$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
   	}
	
	
	
	
 
 
 }
