<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestSeriesModel extends CI_Model {

  	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }
	
	private $Table = 'testseries';
 
		
		
	public function Add($data)
	{  
 		$res = $this->db->insert($this->Table, $data ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	
	
	public function Update($data,$id )
	{  
 
 		$res = $this->db->update($this->Table, $data ,['id' => $id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
	public function Trash($Question_id)
	{  
 
 		$res = $this->db->delete($this->Table,['id' => $Question_id ] ); 
		if($res == 1)
			return true;
		else
			return false;
 	}
 
	 public function All($id) 
	{  
 		$this->db->select('*');
		$this->db->from($this->Table);
		$this->db->where("question_id",$id);
		$this->db->limit(1);
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
		$this->db->from($this->Table);
		$this->db->where("id",$id);
		$this->db->limit(1);
  		$query = $this->db->get();
 		if ($query) {
			 return $query->row_array();
		 } else {
			 return false;
		 }
   	}

 
 }
