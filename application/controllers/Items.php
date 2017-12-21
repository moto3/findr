<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

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
		$data = $this->items_model->get_all(array(
      'items.user_id' => user_id()
    ));
		echo json_encode($data);
	}
	public function save()
	{
    $data = array(
      'storage_id' => $this->input->post('storage_id'),
      'item_name' => $this->input->post('name'),
      'item_description' => $this->input->post('description'),
      'date_last_access' => date('Y-m-d H:i:s'),
      'user_id' => user_id()
    );

		if($this->input->post('item_id') == 0){
			$data['date_created'] = date('Y-m-d H:i:s');
			$item_id = $this->items_model->insert($data);
		}else{
      $item_id = $this->input->post('item_id');
      if(!$this->items_model->belongs_to_user($item_id, user_id())){
        die();
      }
			$this->items_model->update($data, array('item_id'=>$item_id));
		}

		$photo_ids = explode(",", $this->input->post('uploaded_files'));
    if(!empty($photo_ids)){
      $data = array('item_id' => $item_id);
      $this->photos_model->update_batch($data, 'photoId', $photo_ids);
    }
    echo_prompt(true, 'item.save_success');
	}
	public function image_upload()
	{
		$upload_dir = $this->config->item('upload_directory') . user_id() . '/';
		if(!file_exists($upload_dir)){
      mkdir($upload_dir, 0777, true);
    }
    $thumb_upload_dir = $upload_dir . $this->config->item('thumb_upload_directory');
    if(!file_exists($thumb_upload_dir)){
      mkdir($thumb_upload_dir, 0777, true);
    }

		$config['upload_path']          = $upload_dir;
    $config['allowed_types']        = 'gif|jpg|png';
    $config['max_size']             = 10000;
    $config['max_width']            = 20000;
    $config['max_height']           = 20000;
        $this->load->library('upload', $config);

    $output = new stdClass();
    if ( ! $this->upload->do_upload('files')){
      $output->error = $this->upload->display_errors('', '');
    }else{
      $thumb_marker = '_thumb';
      $this->make_thumbnail($this->upload->upload_path.$this->upload->file_name, $thumb_upload_dir, $thumb_marker);
      $data = $this->upload->data();
        
      $item_id = $this->session->userdata('item_id');
      if(!$item_id){
	      $item_id = -1;
	    }
      $data['thumb_name'] = $data['raw_name'] . $thumb_marker . $data['file_ext']; //NOT AVAILABLE FROM CI UPLOAD LIB
      $photo_id = $this->photos_model->insert(
        array(
          'item_id' => $item_id,
          'date_added' => date('Y-m-d H:i:s'),
          'fileName' => $data['file_name'],
          'thumbName' => $data['thumb_name']
        )
      );

			$file = new stdClass();
      $file->photoId = $photo_id;
			$file->url = $this->config->item('upload_url') . $data['raw_name'] . $data['file_ext'];
	    $file->thumbnailUrl = $this->config->item('thumb_upload_url') . $data['thumb_name'];
	    $file->thumbName = $data['thumb_name'];
      $file->fileName = $data['file_name'];
	    $file->type = $data['file_type'];
	    $file->size = $data['file_size'];
	    $output->files[] = $file;
    }
    $output->success = true;
    $output->message = 'item.image_uploaded';
    echo json_encode($output);
	}

	public function make_thumbnail($source_image, $thumb_dir, $thumb_marker){
		$config2['image_library'] = 'gd2';
	    $config2['source_image'] = $source_image;
	    $config2['new_image'] = $thumb_dir;
	    $config2['maintain_ratio'] = TRUE;
	    $config2['create_thumb'] = TRUE;
	    $config2['thumb_marker'] = $thumb_marker;
	    $config2['width'] = 80;
	    $config2['height'] = 80;
	    $this->load->library('image_lib',$config2); 

	    if ( !$this->image_lib->resize()){
	    	echo $this->image_lib->display_errors('', '');
        die();   
	    }
	}

}