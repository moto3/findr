<?php

//UTILITY FUNCTIONS

//USED TO DUMP ALL VALUES
function debug($obj){
	echo "<pre>";
	if(is_array($obj) || is_object($obj)){
		print_r($obj);
	}else{
		echo $obj;	
	}
	exit();
}

function site_title(){
	$CI =& get_instance();
	echo $CI->config->item('site_title');
}

function paginate($data, $per_page, $page){
	if($page < 0){
		$page = 1;
	}
	$start_num = $per_page * ($page - 1);
	return array_slice($data,$start_num,$per_page);
}

function format_text($str){
	return str_replace("\n", "<br/>", $str);
}
function format_state($str){
	$CI =& get_instance();
	$states = $CI->config->item('state');
	return array_search($str, $states);
}

function lipsum($sentences = 1, $paragraph = 1){
	$lipsum_text = array('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur imperdiet tempor consectetur. Vestibulum aliquam ex quis ex dapibus maximus. Quisque mi dolor, pretium egestas egestas nec, finibus non urna. Donec ut elit consectetur, rutrum justo eget, pulvinar purus. Morbi rhoncus turpis nec arcu ultricies elementum. Donec euismod aliquam nibh ac convallis. Quisque laoreet, tellus vitae iaculis blandit, leo lacus commodo odio, ut rhoncus neque quam a sem. Nullam mi urna, finibus ut nibh quis, varius varius nulla. Nam mi metus, molestie nec lorem non, vulputate aliquam nulla. Vestibulum enim metus, faucibus at mi nec, congue sagittis sem. Sed eu dignissim lacus, a consectetur felis. Ut laoreet purus id bibendum bibendum.',
	'Pellentesque eu elit a purus dignissim mattis. Duis pellentesque tortor quam, ut pulvinar nulla feugiat quis. Etiam suscipit volutpat velit, ut rutrum orci interdum eget. Morbi placerat ante nec nibh feugiat, nec convallis eros ultricies. Sed a ipsum non mi bibendum dictum. Cras iaculis viverra massa, viverra varius orci auctor aliquam. Phasellus elit massa, aliquet a luctus et, iaculis vitae est. Curabitur risus nunc, condimentum vel egestas eget, blandit eget magna. Vivamus nec nisi lectus. Fusce nec efficitur nulla.',
	'Nullam vitae nisl nec metus tincidunt dignissim. Aenean quis metus sollicitudin, tincidunt neque et, faucibus est. Phasellus ut luctus elit. Cras sem purus, egestas eget turpis nec, ultricies dapibus orci. Praesent at ipsum id ligula imperdiet ultrices at vel mauris. Sed ac ligula vitae nulla condimentum pretium sit amet ac eros. Curabitur urna sapien, malesuada eu risus id, convallis tempor ante. Duis vel libero tincidunt, consequat est ornare, vulputate felis. Mauris id lorem accumsan enim hendrerit suscipit. Fusce at dolor ultrices, cursus tortor in, mollis ex. Nullam ac nibh ultrices, accumsan neque vel, sollicitudin ex. Donec tempus commodo porta. Cras vitae facilisis mi.',
	'Curabitur vitae felis lacinia, convallis leo eget, iaculis purus. Nam convallis ex dictum egestas elementum. Sed dapibus commodo turpis eu elementum. Vivamus sit amet feugiat velit. Etiam vel nunc a magna laoreet blandit non quis elit. Ut pharetra tellus sit amet dolor viverra pretium vitae eu mauris. Suspendisse potenti. Etiam interdum suscipit molestie. Integer hendrerit imperdiet lectus sed blandit. Proin a sem ligula. Nullam condimentum, odio vel bibendum posuere, purus elit dignissim nibh, ut tincidunt magna mauris in arcu. Sed vel cursus justo. Phasellus euismod nisi congue justo aliquam malesuada fringilla at lacus.',
	'Aenean id consectetur nulla. Maecenas semper tortor quam, vel pharetra sapien blandit et. Etiam sit amet felis auctor, mollis odio ut, tempor mi. Vivamus auctor neque ut odio bibendum, non tempus lorem molestie. Etiam egestas, felis eu elementum venenatis, nisl nisi porttitor libero, quis malesuada libero orci mollis sem. Suspendisse lacinia quam ut magna malesuada cursus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam erat velit, finibus non massa vel, condimentum malesuada ipsum. Donec id purus suscipit risus facilisis aliquet ut non nisl.');
	return substr($lipsum_text[0], 0, strpos($lipsum_text[0], "."));
}

//SETS FLASH MESSAGES BEFORE REDIRECT
function flash_message($message){
	$CI =& get_instance();
	$CI->session->set_flashdata('message', array('class'=>'message', 'message'=>message($message)));
}
function flash_error($message){
	$CI =& get_instance();
	$CI->session->set_flashdata('message', array('class'=>'error', 'message'=>message($message)));
}