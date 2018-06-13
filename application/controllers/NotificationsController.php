<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationsController extends CI_Controller {
 
 
 
 public function index(){
  
 	$this->parser->parse('notification/notification_index',[]);
 
 }
 
 	
	 
}
