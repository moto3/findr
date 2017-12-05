<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Storage extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!is_logged_in()){
			redirect('/users/login');
		}
	}
	public function index(){}
	public function load()
	{	
		$data = $this->storage_spaces_model->get_all(array(), "*", 0, "storage_prefix ASC, storage_number ASC");
    echo json_encode($data);
	}
	public function save()
	{
    $storage_id = $this->input->post('storage_id');
    $data = array(
      'storage_prefix' => $this->input->post('prefix'),
      'storage_number' => $this->input->post('number'),
      'storage_name' => $this->input->post('storage_name'),
      'storage_description' => $this->input->post('description'),
      'date_last_access' => date('Y-m-d H:i:s')
    );
		if($storage_id == 0){
      $data['date_created'] = date('Y-m-d H:i:s');
      $data['user_id'] = user_id();
      $storage_id = $this->storage_spaces_model->insert($data);
    }else{
      if(!$this->storage_spaces_model->belongs_to_user($storage_id, user_id())){
        die();
      }
      $this->storage_spaces_model->update($data, array('storage_id'=>$storage_id));
    }
	}

}