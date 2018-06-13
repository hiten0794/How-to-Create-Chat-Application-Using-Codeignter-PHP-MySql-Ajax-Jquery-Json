<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MessagesController extends CI_Controller {
 
 
 
 public function index(){
 
 	$this->parser->parse('message/message_index',[]);
 
 }

 	
	 
}
