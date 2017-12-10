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
    $data = $this->storage_spaces_model->get(
      array(
        'storage_prefix' => $this->input->post('prefix'),
        'storage_number' => $this->input->post('number')
      )
    );
    if(empty($data)){
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
      $ret = array('success'=>true, 'message'=>'Storage saved successfully.');
    }else{
      $ret = array('success'=>false, 'message'=>'Duplicate storage exists.');
    }
    echo json_encode($ret);
	}
  public function delete()
  {
    $storage_id = $this->input->post('storage_id');
    $data = $this->items_model->get(array('storage_id'=>$storage_id));
    $ret = array();
    if(!empty($data)){
      $ret['success'] = false;
      $ret['message'] = 'storage_not_empty';
    }else{
      if(!$this->storage_spaces_model->belongs_to_user($storage_id, user_id())){
        die();
      }
      $ret['success'] = true;
      $ret['message'] = 'storage_deleted';
      $this->storage_spaces_model->delete(array('storage_id'=>$storage_id));
    }
    echo json_encode($ret);
  }
}
