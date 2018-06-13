<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OrderModel extends CI_Model {

  	public function __construct()

        {

                parent::__construct();

                // Your own constructor code

        }

  	private $Table='orders';

 

	public function AddOrder($data)

	{  

		$res = $this->db->insert($this->Table,$data);

		if($res == 1)

			return $this->db->insert_id();

		else

			return false;	

  	}

	public function OrderStatus($index){

		$status = [

					0 => 'Pending Payment',

					1 => 'Processing',

					2 => 'On Hold',

					3 => 'Completed',

					4 => 'Cancelled',

					5 => 'Refunded',

					6 => 'Failed', 

					 

				];

		return $status[$index];

	}

	

	public function OrderStatusList(){

		$status = [

					0 => 'Pending Payment',

					1 => 'Processing',

					2 => 'On Hold',

					3 => 'Completed',

					4 => 'Cancelled',

					5 => 'Refunded',

					6 => 'Failed', 

					 

				];

		return $status;

	}

	public function OrderDetails($order_id){

		

 		$this->db->select('*');

 		$this->db->from($this->Table);

 		$this->db->where('id',$order_id);

 		$q = $this->db->get();

  			if($q ){

  				return $q->row_array();

  			}else

  				return false;	

	}

	public function SaleProducts($product_id){
  		$this->db->select('*');
  		$this->db->from($this->Table);
  		$this->db->like('product_ids',$product_id);
  		$q = $this->db->get();
   		if($q ){
			return $q->result_array();
  		}else
			return false;

 	}

	

	public function UpdateByID($status, $id)
	{  
 		$res = $this->db->update($this->Table,['order_status' => $status ] ,['id' => $id] ); 
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

