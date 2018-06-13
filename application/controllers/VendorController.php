<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class VendorController extends CI_Controller {
		public function __construct()
        {
                parent::__construct();
               $this->load->model(['ProductModel','CategoryModel']);
        }
 
 	public function register_template(){
		
		$data['title']='Create Vendor Account';
		$this->parser->parse('website/vendor/index_page_vendor',$data);	 
 		
 	}
	
	public function register_api(){
		
		
		$this->OuthModel->CSRFVerify();
 
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
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
           }else{
 				$post = $this->input->post();
 
			$josnfiles='';
			 
			if(count($_FILES['vendorfilesImg']['name']) >= 2){
			 
			 if(count($_FILES['vendorfilesImg']['name']) > 0){
				 
				for($i=0; $i<count($_FILES['vendorfilesImg']['name']); $i++) {
					$tmpFilePath = $_FILES['vendorfilesImg']['tmp_name'][$i];
					$Filesize = $_FILES['vendorfilesImg']['size'][$i];
						if($tmpFilePath != ""){
							if($Filesize < 200000 ){
								$fileNameUp = date('dmYHis').'_'.$_FILES['vendorfilesImg']['name'][$i];
								$filePath = "uploads/vendors-file/".$fileNameUp ;
								if(move_uploaded_file($tmpFilePath, $filePath)) {
									$files[] = $fileNameUp;
								}
							}else{
								$filesizeAr[] =  $_FILES['vendorfilesImg']['name'][$i];
							}
					  }
			 		 }
					 if($filesizeAr > 0){
					 echo json_encode(['status' => 0, 
					 					'message' => '<span style="color:#900;">'. count($filesizeAr). ' Files are too long size. Please upload less than 200 kb<span>' ]); 
 						for($ii=0; $ii<count($files); $ii++){
							//echo $files[$ii];
							unlink("uploads/product/gallery/".$files[$ii]);
						}
					die; 
					}
					
				}
				
				$josnfiles = json_encode($files);
				
			}else{
				echo json_encode(['status'=>0 ,'message' => 'Upload minimum 2 files !']);
				die;
 			}
	
 
					$user_data = [ 	
									'name' => $post['firstname'].' '.$post['lastname'],
									'first_name' => $post['firstname'],
									'last_name' => $post['lastname'],
									'username' => $post['email'],
									'password' => $this->OuthModel->HashPassword($post['password']),
									'role' => 'Vendor',
 									'email' => $post['email'],
									'vendor_file' => $josnfiles ,
  									'ip_address' => $this->input->ip_address(),
									'created' => date('Y-m-d H:i:s'),
 								];
					
					//print_r($user_data); die;
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
	
 	
	
	public function template(){
 		$this->parser->parse('vendor/vendor_list_template',[]);	
 	}
 
 	public function grid_data()
	{
		$this->OuthModel->CSRFVerify();
 		// storing  request (ie, get/post) global array to a variable  
		$requestData = $_REQUEST;
 		//print_r($requestData);
 
  		$table = "users";
		$fields = "id,name,email, role, created ,username,picture_url,status";
 		$id = '';
		$where = " WHERE `role` != 'Admin' ";
 		$sql = "SELECT ".$fields;
		$sql.=" FROM ".$table. $where;
 		//echo $sql;
 		$query = $this->db->query($sql);
		$queryqResults = $query->result();
 		$totalData = $query->num_rows(); // rules datatable
		$totalFiltered = $totalData; // rules datatable
  		
		$where = " WHERE `role` != 'Admin' ";
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
			
			//$tableCheckTD = "<label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label>";
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
			
			$action2='';
			//$action2 = "<a onclick='trash($url_id)' href='javascript:void(0);'><span class='label label-danger'>Remove</span>";
		
															
			$imgUrl = base_url('public/images/user-icon.jpg');											
			if(!empty($row->picture_url)){$imgUrl = base_url('uploads/profiles/'.$row->picture_url);	 }	
			
 			$statusTxt='';
			if($row->status==0){ $statusTxt = "<a onclick='status($url_id,1)' href='javascript:void(0);'><span class='label label-warning'>InActive</span>";}
			else if($row->status==1){ $statusTxt = "<a onclick='status($url_id,0)' href='javascript:void(0);'><span class='label label-primary'>Active</span>";}											
			else{ $statusTxt = "<a href='javascript:void(0);'><span class='label label-danger'>Account Blocked</span>";}
 			
 			$nestedData[] = '<span class="nameID_'.$id.'">'.$row->id.'</span>';
			$nestedData[] = '<span class="nameID_'.$id.'"><img class="img-thumbnail imgcls" src="'.$imgUrl.'"></span>';
			$nestedData[] = '<span class="contactID_'.$id.'">'.$row->email.'</span>';
			$nestedData[] = '<span class="contactID_'.$id.'">'.$row->name.'</span>';
			$nestedData[] = '<span class="contactID_'.$id.'">'.$row->role.'</span>';
			
			$nestedData[] = '<span class="contactID_'.$id.'">'.$statusTxt.'</span>';
			 
 			$nestedData[] = $row->created;
			$nestedData[] =  $action1.$action2; // $action; 
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
	
	
	public function block(){
		$this->OuthModel->CSRFVerify();
		
 		$status = $this->input->get('status');
		$user_id = $this->OuthModel->Encryptor('decrypt',$this->input->get('id'));
		$q = $this->UserModel->StatusUpdateByID($user_id,$status);
		
		
 		if($q==true){
			
			$txtdomain='';
			if($status==2){
				$txtdomain='Blocked';
 			}
			if($status==1){
				$txtdomain='Unblock';
 			}
		
 		 	$json=['status'=>1,'message'=>'User '.$txtdomain.' !'];
		}else{
			$json=['status'=>0,'message'=>'Failed to '.$txtdomain.' !'];
		}
		echo json_encode($json);		
	
	}
 	
	 
}
