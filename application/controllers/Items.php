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
	public function index()
	{
	}
	public function load()
	{	
		$data = $this->items_model->get_all();
		echo json_encode($data);
	}
	public function add()
	{
		$this->load->view('blocks/top');
		$this->load->view('items/add');
		$this->load->view('blocks/bottom');
	}
	public function save()
	{

		$storage_data = array(
			'storage_prefix' => $this->input->post('prefix'),
			'storage_number' => $this->input->post('number'),
		);
		$storage = $this->storage_spaces_model->get(
			$storage_data	
		);
		if(empty($storage)){
			$storage_data->date_created = date('Y-m-d H:i:s');
			$storage_data->date_last_access = date('Y-m-d H:i:s');
			$storage_id = $this->storage_spaces_model->insert($storage_data);
		}else{
			$storage_id = $storage['storage_id'];
		}

		if(empty($this->input->post('item_id'))){
			$insert_data = array(
				'storage_id' => $storage_id,
				'item_name' => $this->input->post('name'),
				'item_description' => $this->input->post('description'),
				'date_created' => date('Y-m-d H:i:s'),
				'date_last_access' => date('Y-m-d H:i:s')
			);
			$item_id = $this->items_model->insert($insert_data);
		}else{
			die('EDIT MODE');
		}
		$photos_submitted = explode(",", $this->input->post('uploaded_files'));
		$photos_match = $this->photos_model->get_where_in('filename', $photos_submitted);
		foreach($photos_match as $photo){
			$this->photos_model->update(
				array('item_id' => $item_id),
				array('photo_id' => $photo['photo_id'])
			);
		}
		$photos = $this->photos_model->get_where_in('filename', $photos_submitted);

		//flash_message('item_add_success');
		//redirect('');
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
	        $photo_id = $this->photos_model->insert(
	        	array(
	        		'item_id' => $item_id,
	        		'date_added' => date('Y-m-d H:i:s'),
	        		'filename' => $data['file_name']
	        	)
	        );

			$file = new stdClass();
			$file->url = $this->config->item('upload_url') . $data['raw_name'] . $data['file_ext'];
	        $file->thumbnailUrl = $this->config->item('thumb_upload_url') . $data['raw_name'] . $thumb_marker . $data['file_ext'];
	        $file->name = $data['file_name'];
	        $file->type = $data['file_type'];
	        $file->size = $data['file_size'];

	        $output->files[] = $file;

        }
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