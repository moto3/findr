<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('blocks/top');
		$this->load->view('login');
		$this->load->view('blocks/bottom');
	}
	public function process()
	{
		if($this->simpleloginsecure->login($this->input->post('email'), $this->input->post('password'))){
			flash_message('login_success');
			redirect('');
		}else{
			flash_error('login_failed');
			redirect('/users/login');
		}
	}
}
