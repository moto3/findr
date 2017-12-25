<?php
function prompt(){
	$CI = & get_instance();
	$message = $CI->session->flashdata('message');
    if( $message ){
		return '<div id="prompt" class="' . $message['class'] . '">' . $message['message'] . '</div>';
	}
}
function csrf_name(){
	$CI = & get_instance();
	return $CI->security->get_csrf_token_name();
}
function csrf_hash(){
	$CI = & get_instance();
	return $CI->security->get_csrf_hash();
}
