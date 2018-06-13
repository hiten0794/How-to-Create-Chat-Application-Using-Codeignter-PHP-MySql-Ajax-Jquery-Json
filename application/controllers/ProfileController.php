<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileController extends CI_Controller {
 
 
 
 public function index(){
 
 	$this->parser->parse('profile/profile_index',[]);
 
 }

	public function change_photo(){
		
		$this->OuthModel->CSRFVerify();
			
			//print_r($_FILES);
			$resonse=['status' => 0, 'message'=> 'false'];
			if(isset($_FILES['userPhoto']['name']) && !empty($_FILES['userPhoto']['name'])){	
				
								$config['upload_path']          = './uploads/profiles';
								$config['allowed_types']        = 'gif|jpg|png';
								$config['max_size']             = 500;
								 //$config['max_width']            = 1024;
								//$config['max_height']           = 768;
								 $this->load->library('upload', $config);
								 if ( ! $this->upload->do_upload('userPhoto'))
								 {
										 echo json_encode(['status' => 0, 'message' => $this->upload->display_errors() ]); die;
								 }
								 else
								 {
										$file_data = $this->upload->data();
										$query =  $this->UserModel->UpdateProfileImageByID(['picture_url'=>$file_data['file_name']]);
										if($query == true){
											$picture_url = base_url('/uploads/profiles/'.$file_data['file_name']);
											$resonse=['status' => 1, 'message'=> 'Profile Image Upload Successfully !','picture_url' => $picture_url];
										}else{
											$resonse=['status' => 0, 'message'=> 'false'];
										}
										
								 }
			}
			echo json_encode($resonse);
		}

	public function change_user_profile_password_update(){
 		 $this->OuthModel->CSRFVerify();
		$post = $this->input->post();
 		
 		if(empty($post['Old'])){
			echo json_encode(['status' => 0 ,'message' => 'Old Password is Required !']);
		}else if(empty($post['New'])){
			echo json_encode(['status' => 0 ,'message' => 'Password is required fields !']); 
		}else if(strlen($post['Confirm'])  < 4 ){ 
			echo json_encode(['status' => 0 ,'message' => 'Password must contain at least 4 characters ! ']); 
		}else if($post['New'] != $post['Confirm'] ){
				echo json_encode(['status' => 0 ,'message' => "password and confirm password don't match"]);  
		}else{
			  
			$checkOldPasswordInDB = $this->OveModel->checkOldPasswordInDB();
			$hashed=$checkOldPasswordInDB['password'];
			
 			 
			if($this->OuthModel->VerifyPassword($post['Old'],$hashed) == 1){
 				 
  				$user_id = $checkOldPasswordInDB['id'];
				$update = $this->OveModel->UpdatePassword($user_id,$this->OuthModel->HashPassword($post['New']));
				if($update == true){
					echo json_encode(['status' => 1 ,'message' => "Password updated !"]);
				}else{
					echo json_encode(['status' => 0 ,'message' => "Faild to password updated, Please try again !"]);
				}
				
			}else{
 				echo json_encode(['status' => 0 ,'message' => "Your old password do not match in databases, please enter correct password !"]);
			}
		}
  	}
	
	public function user_update_profile_data(){
		$this->OuthModel->CSRFVerify();
 		$request = $this->input->post();
 		
		if(!empty($request['first_name'])){$post['first_name'] = $request['first_name'];}
		if(!empty($request['last_name'])){$post['last_name'] = $request['last_name'];}
		
 		if(!empty($request['email'])){$post['email'] = $request['email'];}
		if(!empty($request['mobile_no'])){$post['mobile_no'] = $request['mobile_no'];}
		
		
		if(!empty($request['address'])){$post['address'] = $request['address'];}
		if(!empty($request['about'])){$post['about'] =  $request['about'];}
 		if(!empty($request['pincode'])){$post['pincode'] = $request['pincode'];}
 				
  			$post['name'] = $request['first_name'].' '.$request['last_name'];
  			$post['ip_address'] = $this->input->ip_address();
			$post['modified'] = date('Y-m-d H:i:s');
			
		 
 								
 			$query =  $this->OveModel->UpdateData($this->OuthModel->xss_clean($post));
			if($query == true){ 
				$message = [
							'status' => 1,
							'message' => 'Profile updated !',
							'updateName' => $post['name']
 						];
			}else{
				$message = [
							'status' => 0,
							'message' => 'Faild to updated !'
						];
			}
 			echo json_encode($message);
				
 	}
	public function forgot_password(){
 		$this->parser->parse('login/forgot_password_template',[]);
	}
	public function forgot_password_email(){
		$this->OuthModel->CSRFVerify(); 
		
		$email=$this->input->get('email');
		$ifexists = $this->UserModel->IfExistEmail($email);
		
		if($ifexists != false){
			
			$new_password = $this->OuthModel->RandomPassword();
 
 				$user_id = $ifexists['id'];
				$update = $this->OveModel->UpdatePassword($user_id,$this->OuthModel->HashPassword($new_password));
				if($update == true){
					$message = ['status' => 1 ,'message' => "Your new password has been sent to your email address. !"];
				}else{
					$message = ['status' => 0 ,'message' => "Faild to password updated, Please try again !"];
				}
 			
 		}else{
				$message = [
							'status' => 0,
							'message' => 'Sorry Your Email Not exists in the database !'
						];
		}
 		
		echo json_encode($message);
	}
		
	 
	
	 
}
