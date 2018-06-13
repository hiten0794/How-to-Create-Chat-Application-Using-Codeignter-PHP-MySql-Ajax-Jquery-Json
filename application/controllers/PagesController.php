<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PagesController extends CI_Controller {
 
 public function index(){
  	$this->parser->parse('login/index_login',[]);
  }
 
 
 	 
}
