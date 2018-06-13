<?php



defined('BASEPATH') OR exit('No direct script access allowed');







class ProductModel extends CI_Model {







  	public function __construct()



        {

                parent::__construct();

                // Your own constructor code

        }



	



	private $Product = 'products';



	



 	public function Slug($name)



 		{



 			$count = 0;



 			$name = strtolower(url_title($name));



 			$slug_name = $name;             // Create temp name



 			while(true) 



 			{



 				$this->db->select('id');



  



				$this->db->where('slug', $slug_name);   // Test temp name







				$query = $this->db->get($this->Product);







				if ($query->num_rows() == 0) break;







				$slug_name = $name . '-' . (++$count);  // Recreate new temp name







			}



 			return $slug_name;      // Return temp name







	 }



		



		



	public function Add($data)



	{  



 		$res = $this->db->insert($this->Product, $data ); 



		if($res == 1)



			return $this->db->insert_id();



		else



			return false;



 	}



	



	



	public function Update($data,$id)

  	{  

  		$res = $this->db->update($this->Product, $data ,['id' => $id ] ); 

 		if($res == 1)

 			return true;

 		else

 			return false;

  	}



	public function TrashByID($id)



	{  



  		$res = $this->db->delete($this->Product,['id' => $id ] ); 



		if($res == 1)



			return true;

 		else

 			return false;



 	}



  	public function DropDownQuestions()



	{  



 		$this->db->select('id,QuestionName,SalePrice');



		$this->db->from($this->Product);



   		$query = $this->db->get();



 		if ($query) {



			 return $query->result_array();



		 } else {



			 return false;



		 }



   	}





	public function ProductBlockByVendorID($user_id)

  	{  

  		$res = $this->db->update($this->Product, ['status' => 0]  ,['user_id' => $user_id ] ); 

 		if($res == 1)

 			return true;

 		else

 			return false;

  	}

	public function ProductUnBlockByVendorID($user_id)

  	{  

  		$res = $this->db->update($this->Product, ['status' => 1]  ,['user_id' => $user_id ] ); 

 		if($res == 1)

 			return true;

 		else

 			return false;

  	}

	public function ProductBlockByCateID($id)

  	{  

  		$res = $this->db->update($this->Product, ['status' => 0]  ,['id' => $id ] ); 

 		if($res == 1)

 			return true;

 		else

 			return false; 

  	}

	public function ProductUnBlockByCateID($id)

  	{  

  		$res = $this->db->update($this->Product, ['status' => 1]  ,['id' => $id ] ); 

 		if($res == 1)

 			return true;

 		else

 			return false; 

  	}

	



	



	 public function GetProductListByUser_Id($user_id) 



	{  



 		$this->db->select('id,name');



		$this->db->from($this->Product);



		$this->db->where("user_id",$user_id);



   		$query = $this->db->get();



 		if ($query) {



			 return $query->result_array();



		 } else {



			 return false;



		 }



   	}



	



	



	



	



	



  	



	 public function GetById($id) 

 	{  



 		$this->db->select('*');



		$this->db->from($this->Product);



		$this->db->where(["id"=>$id]);



		$this->db->limit(1);



  		$query = $this->db->get();



 		if ($query) {



			 return $query->row_array();



		 } else {



			 return false;



		 }



   	}

	

	 public function GetBySlug($slug) 

 	{  

  		$this->db->select('*');

 		$this->db->from($this->Product);

 		$this->db->where(["slug"=>$slug,"status"=>1]);

 		$this->db->limit(1);

   		$query = $this->db->get();

  		if ($query) {

 			 return $query->row_array();

 		 } else {

 			 return false;

 		 }



   	}

	

	public function RelatedProducts($cate_id,$current_p_id) 

 	{  

		$condition=['cate_id' => $cate_id, 'id !=' => $current_p_id ];

  		$this->db->select('*');

 		$this->db->from($this->Product);

 		$this->db->where($condition);

    		$query = $this->db->get();

  		if ($query) {

 			 return $query->result_array();

 		 } else {

 			 return false;

 		 }



   	}

	



	public function GetByProductGallerImages($id) 



	{  



 		$this->db->select('id,gallery_images');



		$this->db->from($this->Product);



		$this->db->where("id",$id);



		$this->db->limit(1);



  		$query = $this->db->get();



		$res=$query->row_array();



 		return $res;



   	}



	



	



	public function GetQuestionByCategory($cate_id) 



	{  



 		$this->db->select('question_id,e_name,h_name');



		$this->db->from($this->Product);



		$this->db->where("question_type",$cate_id);



   		$query = $this->db->get();



 		return $query->result_array();



 



   	}



	



	



	public function GetQuestionBySection($series_id,$section_id) 



	{  



	



		$condiation = ['series_id' => $series_id , 'section_id' => $section_id  ];



 		$this->db->select('question_id,e_name,h_name');



		$this->db->from($this->Product);



		$this->db->where($condiation);



   		$query = $this->db->get();



 		return $query->result_array();



 



   	}



	 public function AllProducts() 

 	{  



 		$this->db->select('id');



		$this->db->from($this->Product);



    	$query = $this->db->get();



 		$u=$query->num_rows();



		return $u;

 

   	}



	 public function AllProductsByVendor($user_id) 

 	{  



 		$this->db->select('id');



		$this->db->from($this->Product);

		$this->db->where('user_id',$user_id);

    	$query = $this->db->get();



 		$u=$query->num_rows();



		return $u;

 

   	}	



	



		



	public function GetProductsByCateID($cate_id) 



	{  



 		$condiation = [ 'cate_id' => $cate_id,'status' => 1  ];

  		$this->db->select('id,name,subcate_id,slug,description,sale_price,purchase_price,main_image');

 		$this->db->from($this->Product);

 		$this->db->where($condiation);

    	$query = $this->db->get();

  		return $query->result_array();



 



   	}



	



	public function GetByProductDetails($id) 

 	{  

  		$this->db->select('id,name,description,user_id,main_image,sale_price,status');

 		$this->db->from($this->Product);



		$this->db->where(["id"=>$id,"status" => 1]);



		$this->db->limit(1);



  		$query = $this->db->get();



		$res=$query->row_array();



 		return $res;



   	}

	

	public function GetAllProductOnShop() 

 	{  

  		$this->db->select('*');

 		$this->db->from($this->Product);

		$this->db->where("status",1);

     	$query = $this->db->get();

		$res=$query->result_array();

  		return $res;



   	}

	

	public function GetAllProductOnShopByCateID($condition) 

 	{  

	 

  		$this->db->select('*');

 		$this->db->from($this->Product);

		$this->db->where($condition);

    	$query = $this->db->get();

		$res=$query->result_array();

  		return $res;



   	}

	

	public function GetAllProductSearchUsingCateogryId($ids) 
  	{  
  		 
  		$this->db->select('*');

 		$this->db->from($this->Product);

		$this->db->where("status",1);
		
		$this->db->where_in('cate_id',$ids);
		
    	$query = $this->db->get();

		$res=$query->result_array();

  		return $res;

 
   	}

	public function GetAllProductSearchUsingSubCateogryId($subcate_id) 
  	{  
 		//$ids = explode(',', $subcate_id); 
		 
  		$this->db->select('*');

 		$this->db->from($this->Product);

		$this->db->where("status",1);
		
		//if(!empty($subcate_id )){
			
		$this->db->where_in('subcate_id',$subcate_id);
		//}
    	$query = $this->db->get();

		$res=$query->result_array();

  		return $res;

 
   	}
	public function GetAllProductSearchUsingMainNCateogryId($id) 
  	{  
 		//$ids = explode(',', $subcate_id); 
		 
  		$this->db->select('*');

 		$this->db->from($this->Product);

		$this->db->where("status",1);
  			
		$this->db->where_in('cate_id',$id);
		
     	$query = $this->db->get();

		$res=$query->result_array();

  		return $res;

 
   	}
	
	 public function GetAllProductSearchUsingSubBrandId($id) 
  	{  
   		$this->db->select('*');

 		$this->db->from($this->Product);

		$this->db->where("status",1);
  			
		$this->db->where_in('brand_id',$id);
		
     	$query = $this->db->get();

		$res=$query->result_array();

  		return $res;

 
   	}
	
	public function ProductByVendorId($vendor_id) 
  	{  
 		//$ids = explode(',', $vendor_id); 
		 
  		$this->db->select('*');

 		$this->db->from($this->Product);

		$this->db->where("status",1);
		
		if(!empty($vendor_id)){
			
		$this->db->where_in('user_id',$vendor_id);
		}
    	$query = $this->db->get();

		$res=$query->result_array();

  		return $res;

 
   	}	
	
	public function ProductByVendorIdAndCate($vendor_id,$ids) 
  	{  
 		//$ids = explode(',', $vendor_id); 
   		$this->db->select('*');
  		$this->db->from($this->Product);
 		$this->db->where("status",1);
		
 		$this->db->where('user_id',$vendor_id);
		$this->db->where_in('subcate_id',$ids);
     	$query = $this->db->get();

		$res=$query->result_array();

  		return $res;
   }	
	

	public function ProductByPriceRange($range) 
		{  
 			$this->db->select('*');
 			$this->db->from($this->Product);
 			$this->db->where("status",1);
 			$this->db->where($range);
 			$query = $this->db->get();
 			$res=$query->result_array();
 			return $res;
 	 
		}		

	

	

	public function GetSimilarProducts($subcate_id) 

 	{  

  		$condiation = [ 'subcate_id' => $subcate_id,'status' => 1  ];

  		$this->db->select('id,name,subcate_id,slug,description,sale_price,purchase_price,main_image,gallery_images');

 		$this->db->from($this->Product);

 		$this->db->where($condiation);

    	$query = $this->db->get();

  		return $query->result_array();



 



   	}

	

	public function GetCompareProduct($id) 

 	{  
  		$this->db->select('*');

 		$this->db->from($this->Product);

		$this->db->where("status",1);

		$this->db->where('id',$id);

    	$query = $this->db->get();

		$res=$query->result_array();

  		return $res;
    }

	public function BestSelling() 
  	{  
  		$this->db->select('id,slug,name,main_image');
  		$this->db->from($this->Product);
 		$this->db->where("status",1);
  		$this->db->order_by('rand()');
    	$this->db->limit(1);
     	$query = $this->db->get();
 		$res=$query->result_array();
   		return $res;
    }	
	public function BestOffer() 
  	{  
  		$this->db->select('id,slug,name,main_image');
  		$this->db->from($this->Product);
 		$this->db->where("status",1);
  		$this->db->order_by('rand()');
    	$this->db->limit(2);
     	$query = $this->db->get();
 		$res=$query->result_array();
   		return $res;
    }
	public function Trending() 
  	{  
  		$this->db->select('id,slug,name,main_image');
  		$this->db->from($this->Product);
 		$this->db->where("status",1);
  		$this->db->order_by('rand()');
    	$this->db->limit(1);
     	$query = $this->db->get();
 		$res=$query->result_array();
   		return $res;
    }	



	



	



	



	



	



 



 }



