<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CustomerController extends CI_Controller {
 	  
	  public function __construct()
        {
                parent::__construct();
				$this->load->model(['CartModel']);
                 
        }
	
	public function webuserlogin(){
		$post = $this->input->post();
		
		$secret="6Lf3QVkUAAAAAP7GsTVkl8gpLB3O-dcGv7I8UHr2";
		$response=$post["captcha"];
		
		$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
		$captcha_success=json_decode($verify);
		if ($captcha_success->success==false) {
		  //This user was not verified by recaptcha.
			 
			$message = ['status' => 0, 'message' => 'Please re-enter your reCAPTCHA ! '];
			echo json_encode($message); die;
		}
		else if ($captcha_success->success==true) {
		  //This user is verified by recaptcha
 
		$this->OuthModel->CSRFVerify();
  		
   		$data = [
  					'username' => $post['email'],
  				];
 		
 		$result = $this->OveModel->Authentication_Check($data);
		if($result != false){
			
			 $login_user_id = $result['id'];
			 $user = $this->OveModel->Read_User_Information($login_user_id);
			 $hashed=$user['password'];
 			
 			  if($this->OuthModel->VerifyPassword($post['password'],$hashed) == 1){
				  
				 if($user['role'] == 'Customer'){
					 
					  if($user['is_email_verify'] == '0'){ // email verify
 						$message = ['status' => 0, 'message' => 'Your email has not been verified. please check your registerd email !'];
					  }else if($user['status'] == '2'){ // admin status blocked
						$message = ['status' => 0, 'message' => 'Your account is blocked please contact administrator ! '];
 					  }else{
					 	$userdata = [
							'id'  => $user['id'],
							'username'  => $user['username'],
							'email'     => $user['email'],
							'name'     => $user['name'],
							'role' => $user['role'],
							//'last_logged' =>  $user['lastlogged'],
							'created' =>  $user['created'], 
							'User_logged_in' => 'TRUE'
						];
						 
 						$this->session->set_userdata('User',$userdata);
						$guest_user_id = $this->session->userdata('guest_user_id');
						$check_user_session_cart_data =  $this->CartModel->GetGuestUserDataLoginTime($guest_user_id);
						
						if($check_user_session_cart_data != false){
							$this->CartModel->UpdateGuestUserDataLoginSuccess($guest_user_id,$user['id']);
						}
  						$message = [ 'status' =>1 , 
								'message' => 'You are now successfully Login !', 
								'userDataDB' => $userdata, 
								'redirectUrl' => base_url('my-account')
							];
					}//else
				
 				 }else if($user['role'] == 'Vendor' || $user['role'] == 'Client_cs'){
					
					if($user['is_email_verify'] == '0'){ // email verify
 						$message = ['status' => 0, 'message' => 'Your email has not been verified. please check your registerd email !'];
							
					}else if($user['status'] == '0'){ // admin approve status
						$message = ['status' => 0, 'message' => 'Your account not activated please contact administrator ! '];
							
					}else if($user['status'] == '2'){ // admin status blocked
						$message = ['status' => 0, 'message' => 'Your account is blocked please contact administrator ! '];
 					}else{ // finally visit account page
					
					$userdata = [
							'id'  => $user['id'],
							'username'  => $user['username'],
							'email'     => $user['email'],
							'name'     => $user['name'],
							'role' => $user['role'],
							//'last_logged' =>  $user['lastlogged'],
							'created' =>  $user['created'], 
							'logged_in' => 'TRUE'
						];
					
 				 	 	$this->session->set_userdata('Admin',$userdata);
						$message = [ 'status' =>1 , 
								'message' => 'You are now successfully Login !', 
								'userDataDB' => $userdata, 
								'redirectUrl' => base_url('v3/dashboard')
							];
 					}
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
 	}
   	public function register(){
		
		$this->OuthModel->CSRFVerify();
  		 
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
 		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]',
								array(
										'required'      => 'You have not provided %s.',
										'is_unique'     => 'This %s already exists.'
								));
 
 		$this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[password]');
		$this->form_validation->set_rules('tc', 'terms & conditions', 'required');
		
  		
		 if ($this->form_validation->run() == FALSE)
         {
 			 $response = ['status' => 0 ,'message' => '<span style="color:#900;">'.validation_errors().'</span>' ];
			 echo json_encode($response);
			 die;
			  
         }else{
 
				$post = $this->input->post();
 				 
						$user_data = [ 	
									'name' => $post['first_name'].' '.$post['last_name'],
									'first_name' => $post['first_name'],
									'last_name' => $post['last_name'],
									'username' => $post['email'],
									'password' => $this->OuthModel->HashPassword($post['password']),
									'role' => 'Customer',
 									'email' => $post['email'],
  									'ip_address' => $this->input->ip_address(),
									'created' => date('Y-m-d H:i:s'),
 								];
					$user_id = $this->UserModel->AddMember($this->OuthModel->xss_clean($user_data));
					
					if($user_id != false){
						
						$messageString= "Your are registerd successfully !";
						
							$user = $this->OveModel->Read_User_Information($user_id);
							
							$from_email = "optisoft@appdrawing.com";
							$replyemail = "optisoft@appdrawing.com";
							$to_email= $user['email'];
							$name= $user['name'];
							$subject= "Mail From XYZ.Com";
							
							$txtdomain = '&txtdomain='.$this->OuthModel->Encryptor('encrypt',$user['id']).'&is_email_verify='.$this->OuthModel->Encryptor('encrypt',$user['name']);
							
							$verifyLink = base_url('verify-mail?action=verify'.$txtdomain);
							
							$body='';
							$body.= '<p>Name : '.$user['name'].'</p>';
							$body.= '<p>Username : '.$user['email'].'</p>';
							$body.= '<p>Click to below Verify link and Activate Your account !</p>';
							$body.= '<p><a href="'.$verifyLink.'">'.$verifyLink.'</a></p>';
							
							$this->OveModel->SMTP_Config();
							$this->email->set_newline("\r\n");
							$this->email->set_mailtype("html");
							$this->email->from($from_email,$name);
							$this->email->to($to_email);
							$this->email->reply_to($replyemail);
							$this->email->subject($subject);
							$this->email->message($body);
							$this->email->send();
							
							$messageString='Your account has been successfully created. An email has been sent to you with detailed instructions on how to activate it.';							
 						 
 						echo json_encode(['status' => 1 ,'message' => $messageString ]);
					}else{
						echo json_encode(['status' => 0 ,'message' => "Faild to registerd, Please try again !"]);
					}
		 }
 		
 	}
	
	public function verify_mail(){
		
 		$get = $this->input->get();
		$name = $this->OuthModel->Encryptor('decrypt',$get['is_email_verify']);
		$user_id = $this->OuthModel->Encryptor('decrypt',$get['txtdomain']);
 		$res = $this->UserModel->EmailVerifyStatusUpdate($user_id);
 		if(!empty($res)){
			if($res['is_email_verify']==0){
 				$r = $this->db->update('users',['is_email_verify' => 1],['id' => $user_id ] ); 
				if($r==1){
					$data['title']='Thank you your account has been activated successfully';
					$this->parser->parse('website/email_verify',$data);	
				} 
			}else{
 			 redirect(base_url());
			}
		}else{
			redirect(base_url());
		}
		
		 
	}
	
 	public function webuserlogout(){
	
		$this->session->unset_userdata('User');
		redirect(base_url());
	}
	
	public function template(){
 		$this->parser->parse('customer/customer_list_template',[]);	
 	}
 
 	public function grid_data()
	{
		$this->OuthModel->CSRFVerify();
 		// storing  request (ie, get/post) global array to a variable  
		$requestData = $_REQUEST;
 		//print_r($requestData);
 
  		$table = "users";
		$fields = "id,name,email, mobile_no, created ,username,picture_url,status";
 		$id = '';
		$where = " WHERE `role` = 'Customer' ";
 		$sql = "SELECT ".$fields;
		$sql.=" FROM ".$table. $where;
 		//echo $sql;
 		$query = $this->db->query($sql);
		$queryqResults = $query->result();
 		$totalData = $query->num_rows(); // rules datatable
		$totalFiltered = $totalData; // rules datatable
  		
		$where = " WHERE `role` = 'Customer' ";
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
			
			$url_id= '"'.$this->OuthModel->Encryptor('encrypt',$row->id).'"';
			
			$tableCheckTD = "<label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label>";
 			$action =  "<div class='action-buttons'>&nbsp;&nbsp;&nbsp;
 																<a onclick='trash($url_id)'  class='red trashID' href='javascript:void(0);'>
																	<i class='ace-icon fa fa-trash-o bigger-130'></i>
																</a>
 															</div>";
			
			if($row->status==2){
				$action1 = "<a onclick='block($url_id,1)' href='javascript:void(0);'><span class='label label-danger'>Unblock</span>&nbsp;";
			}if($row->status==0 ||$row->status==1){
				$action1 = "<a onclick='block($url_id,2)' href='javascript:void(0);'><span class='label label-danger'>Block</span>&nbsp;";
			}
															
			$imgUrl = base_url('public/images/user-icon.jpg');											
			if(!empty($row->picture_url)){$imgUrl = base_url('uploads/profiles/'.$row->picture_url);	 }	
			
 			
			//if($row->status==0){ $statusTxt = "<a onclick='status($url_id,1)' href='javascript:void(0);'><span class='label label-warning'>InActive</span>";}
			//if($row->status==1){ $statusTxt = "<a onclick='status($url_id,0)' href='javascript:void(0);'><span class='label label-primary'>Active</span>";}											
 			
 			$nestedData[] = '<span class="nameID_'.$id.'">'.$row->id.'</span>';
			$nestedData[] = '<span class="nameID_'.$id.'"><img class="img-thumbnail imgcls" src="'.$imgUrl.'"></span>';
			$nestedData[] = '<span class="contactID_'.$id.'">'.$row->email.'</span>';
			$nestedData[] = '<span class="contactID_'.$id.'">'.$row->name.'</span>';
			$nestedData[] = '<span class="contactID_'.$id.'">'.$row->mobile_no.'</span>';
 			
			//$nestedData[] = '<span class="contactID_'.$id.'">'.$statusTxt.'</span>';
			 
 			$nestedData[] = $row->created;
			$nestedData[] =  $action.$action1; 
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
	
	
	public function status(){
		$this->OuthModel->CSRFVerify();
		
		$status = $this->input->get('status');
		$q = $this->UserModel->StatusUpdateByID($this->OuthModel->Encryptor('decrypt',$this->input->get('id')),$status);
		$txtdomain='InActive';
		if($status==1){$txtdomain='Activate';}
		
 		if($q==true){
			
		 	$json=['status'=>1,'message'=>'User '.$txtdomain.' !'];
		}else{
			$json=['status'=>0,'message'=>'Failed to '.$txtdomain.' !'];
		}
		echo json_encode($json);
	}
	public function trash(){
		$this->OuthModel->CSRFVerify();
		
		$q = $this->UserModel->TrashByID($this->OuthModel->Encryptor('decrypt',$this->input->get('id')));
		if($q==true){
		 	$json=['status'=>1,'message'=>'User Deleted !'];
		}else{
			$json=['status'=>0,'message'=>'Failed to Deleted !'];
		}
		echo json_encode($json);
	}
 	
	 
}
