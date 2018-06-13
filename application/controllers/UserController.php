<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class UserController extends CI_Controller {

 

 

 

 public function userlogin(){

		

		$this->OuthModel->CSRFVerify();

 		

 		$post = $this->input->post();

		

  		$data = [

  					'username' => $post['email'],

					

 				];

 		

 		$result = $this->OveModel->Authentication_Check($data);

		if($result != false){

			

			 $login_user_id = $result['id'];

			 $user = $this->OveModel->Read_User_Information($login_user_id);

			 $hashed=$user['password'];

 			

			 

			  if($this->OuthModel->VerifyPassword($post['password'],$hashed) == 1){

				

					

				 if($user['role'] == 'Admin' || $user['role'] == 'Vendor' || $user['role'] == 'Client_cs'){ //&& $user['status'] == 1

						

 					$userdata = [

							'id'  => $user['id'],

							'username'  => $user['username'],

							'email'     => $user['email'],

							'name'     => $user['name'],

							'role' => $user['role'],

							'last_logged' =>  $user['lastlogged'],

							'created' =>  $user['created'], 

							'logged_in' => 'TRUE'

					];

					

					$this->session->set_userdata('Admin',$userdata);

					 

					//if($user['role'] == 'Admin'){ redirect('v3/dashboard');}

					//if($user['role'] == 'Customer' ){ redirect('v3/profile');}

					

					 

					$message = [ 'status' =>1 , 

								'message' => 'You are now successfully Login !', 

								'userDataDB' => $userdata, 

								'redirectUrl' => base_url('v3/dashboard')

							];

 

				}else{

					

					$message = [ 'status' =>0 , 'message' => 'Unauthorized access !' ];

				}

			

			}else{

				$message = [ 'status' =>0 , 'message' => 'Your password is Incorrect  !' ];

			}

  			 

		}else{

			 $message = [ 'status' =>0 , 'message' => 'Your username is Incorrect  !' ];

		}

		

		echo json_encode($message);

		 

		

 

	}

	

	

	public function register_user(){

		

		$this->OuthModel->CSRFVerifyLogin();

		

 		 

		$this->form_validation->set_rules('fullname', 'Name', 'required');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');

 		$this->form_validation->set_rules('mobile', 'Address', 'required');

		$this->form_validation->set_rules('password', 'password', 'required');

		

  		

		 if ($this->form_validation->run() == FALSE)

         {

 			 $response = ['status' => 0 ,'message' => '<span style="color:#900;">'.validation_errors().'</span>' ];

			 echo json_encode($response);

			 die;

			  

         }else{

			 

				$post = $this->input->post();

 				 

					

						$user_data = [ 	

									'name' => $post['fullname'],

									'username' => $post['email'],

									'password' => $this->OuthModel->HashPassword($post['password']),

									'role' => 'User',

									'source' => 1,

									'email' => $post['email'],

									'mobile_no' => $post['mobile'],

 									'ip_address' => $this->input->ip_address(),

									'created' => date('Y-m-d H:i:s'),

 								];

					$create_member = $this->UserModel->AddMember($this->OuthModel->xss_clean($user_data));

					

					if($create_member == true){

						echo json_encode(['status' => 1 ,'message' => "Your are registerd successfully !"]);

					}else{

						echo json_encode(['status' => 0 ,'message' => "Faild to registerd, Please try again !"]);

					}

		 }

 		

 	}

	

	public function logout(){

	
		$this->session->unset_userdata('Admin');
		//$this->session->sess_destroy();

		 redirect(base_url());

	}

	

	

	

	

	

	public function userslist(){

 		$this->parser->parse('admin/users/users_list_template',[]);	

 	}

 	 	



 	public function users_grid_data()

	{

		$this->OuthModel->CSRFVerify();

 		// storing  request (ie, get/post) global array to a variable  

		$requestData = $_REQUEST;

 		//print_r($requestData);

 

  		$table = "users";

		$fields = "id,name,email, mobile_no, created ,username,picture_url,source";

 		$id = '';

		$where = " WHERE `role` = 'User' ";

 		$sql = "SELECT ".$fields;

		$sql.=" FROM ".$table. $where;

 		//echo $sql;

 		$query = $this->db->query($sql);

		$queryqResults = $query->result();

 		$totalData = $query->num_rows(); // rules datatable

		$totalFiltered = $totalData; // rules datatable

  		

		$where = " WHERE `role` = 'User' ";

 		$sql = "SELECT ".$fields;

 		$sql.=" FROM ".$table . $where ;

 		

  		

		if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

			

			$searchValue = $requestData['search']['value'];

 				

			$sql.=" AND `name` LIKE '%".$searchValue."%' ";   

			$sql.=" AND `username` LIKE '%".$searchValue."%' ";   

 			$sql.=" OR `email` LIKE '%".$searchValue."%' ";

 			$sql.=" OR `mobile_no` LIKE '%".$searchValue."%' ";

		}

 		

		

 		$query = $this->db->query($sql);

 		$totalFiltered = $query->num_rows(); // rules datatable

 		//ORDER BY id DESC	

 		$sql.=" ORDER BY  created  ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

 		$query = $this->db->query($sql);

 		//echo $sql;

 		$SearchResults = $query->result();

		

  		$data = array();

		foreach($SearchResults as $row){

			$nestedData=array(); 

			

			$id = $row->id;

			

			$url_id= $row->id;//$this->OuthModel->Encryptor('encrypt',$row->id);

			

			$tableCheckTD = "<label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label>";

 			$action =  '<div class="action-buttons"><a target="_blank" href="'.base_url('v3/user-full-view?id='.$url_id).'#!/country/india" class="green" href="javascript:void(0);">

																	<i class="ace-icon fa fa-eye bigger-130"></i>

																</a>&nbsp;&nbsp;&nbsp;

 																<a onclick="trash('.$id.')"  class="red trashID" href="javascript:void(0);">

																	<i class="ace-icon fa fa-trash-o bigger-130"></i>

																</a>

 															</div>';

															

			$imgUrl = base_url('public/images/user-icon.jpg');											

			if(!empty($row->picture_url)){$imgUrl = base_url('uploads/profiles/'.$row->picture_url);	 }	

			

 

														

 			

 			$nestedData[] = '<span class="nameID_'.$id.'">'.$row->id.'</span>';

			$nestedData[] = '<span class="nameID_'.$id.'"><img class="img-thumbnail imgcls" src="'.$imgUrl.'"></span>';

			$nestedData[] = '<span class="contactID_'.$id.'">'.$row->email.'</span>';

			$nestedData[] = '<span class="contactID_'.$id.'">'.$row->name.'</span>';

			$nestedData[] = '<span class="contactID_'.$id.'">'.$row->mobile_no.'</span>';

			

			$nestedData[] = '<span class="contactID_'.$id.'">Active</span>';

			$nestedData[] = '<span class="contactID_'.$id.'"></span>';

 			$nestedData[] = $row->created;

			$nestedData[] =  $action; 

  			$data[] = $nestedData;

		}

 		$json_data = array(

					"draw"            => intval( $requestData['draw'] ),  

					"recordsTotal"    => intval( $totalData ),  // total number of records

					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching,  

					"data"            => $data   // total data array

					);

 		echo json_encode($json_data);  // send data as json format					

 	}



	 

	

	 

}

