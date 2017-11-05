<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploaded_files extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!is_logged_in()){
			redirect('/users/login');
		}
	}
	public function index()
	{
		show_404();
	}
	public function view($filename = '')
	{
		$file_dir = $this->config->item('upload_directory') . user_id() . '/' . $filename;
		if(file_exists($file_dir))
		{
			header('Content-Type: ' . mime_content_type($file_dir));
			readfile($file_dir);
		}
	}
	public function thumbs($filename = '')
	{
		$file_dir = $this->config->item('upload_directory') . user_id() . '/' . $this->config->item('thumb_upload_directory') . '/' . $filename;
		if(file_exists($file_dir))
		{
			header('Content-Type: ' . mime_content_type($file_dir));
			readfile($file_dir);
		}
	}
}
