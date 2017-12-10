<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!is_logged_in()){
			//redirect('/users/login');
		}
	}
	public function index()
	{
		//flash_message('login_success');
		$this->load->view('blocks/top');
		//$this->load->view('prompt');
		//$this->load->view('find');
		$this->load->view('dashboard');
		//$this->load->view('items/add');
		//$this->load->view('bottom-widgets');
		$this->load->view('blocks/bottom');
	}
}
