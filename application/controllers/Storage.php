<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Storage extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!is_logged_in()){
			die();
		}
	}
	public function index(){}
	public function load()
	{	
		$data = $this->storage_spaces_model->get_all(array('user_id'=>user_id()), "*", 0, "storage_prefix ASC, storage_number ASC");
    echo json_encode($data);
	}
	public function save()
	{
    $storage_id = $this->input->post('storage_id');
    $search_data = array(
      'storage_prefix' => $this->input->post('prefix'),
      'storage_number' => $this->input->post('number'),
      'user_id' => user_id(),
      'storage_id <> ' => $storage_id 
    );
    if(!empty($this->storage_spaces_model->get($search_data))){
      echo_prompt(false, 'storage.duplicate_exists');
      die();
    }

    $save_data = array(
      'storage_prefix' => $this->input->post('prefix'),
      'storage_number' => $this->input->post('number'),
      'storage_name' => $this->input->post('storage_name'),
      'storage_description' => $this->input->post('description'),
      'date_last_access' => date('Y-m-d H:i:s')
    );        
    if($storage_id != 0){
      if(!$this->storage_spaces_model->belongs_to_user($storage_id, user_id())){
        die();
      }
      $this->storage_spaces_model->update($save_data, array('storage_id'=>$storage_id));
    }else{
      $save_data['date_created'] = date('Y-m-d H:i:s');
      $save_data['user_id'] = user_id();
      $storage_id = $this->storage_spaces_model->insert($save_data);
    }
    echo_prompt(true, 'storage.save_success');
	}
  public function delete()
  {
    $storage_id = $this->input->post('storage_id');
    $data = $this->items_model->get(array('storage_id'=>$storage_id));
    $ret = array();
    if(!empty($data)){
      echo_prompt(false, 'storage.not_empty');
    }else{
      if(!$this->storage_spaces_model->belongs_to_user($storage_id, user_id())){
        die();
      }
      $this->storage_spaces_model->delete(array('storage_id'=>$storage_id));
      echo_prompt(true, 'storage.delete_success');
    }
  }
}
