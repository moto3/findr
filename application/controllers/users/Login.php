<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{	
	  echo $this->simpleloginsecure->login($this->input->post('email'), $this->input->post('password')) ? 1 : 0;
	}
	public function check(){
	  echo login_check() ? 1 : 0;
	}
}
