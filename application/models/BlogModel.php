 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class BlogModel extends CI_Model {
   	public function __construct()

        {

                parent::__construct();
                 // Your own constructor code

         } 
 	private $Table = 'blogs';
	
 
	public function Post($data){
  		$res = $this->db->insert($this->Table, $data ); 
 		if($res == 1)
 			return true;
 		else
 			return false;
	}
	public function Blogs(){
  		
		$this->db->select('*');
		$this->db->from($this->Table);
		$this->db->where('status',1);
		$this->db->order_by('id','desc');
    	$query = $this->db->get();
 		if ($query) {
			 return $query->result_array();
		 } else {
			 return false;
		 }
	}
	public function GetById($id){
  		
		$this->db->select('*');
		$this->db->from($this->Table);
    	$this->db->where('id',$id);
		$query = $this->db->get();
 		if ($query) {
			 return $query->row_array();
		 } else {
			 return false;
		 }
	}
	public function Update($data,$id)
	{  
 		$res = $this->db->update($this->Table, $data ,['id' => $id] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}	
	
	public function TrashById($id)
	{  
 		$res = $this->db->delete($this->Table, ['id' => $id] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}	


 }