<?php
function prompt(){
	$CI = & get_instance();
	$message = $CI->session->flashdata('message');
    if( $message ){
		$outstr  = '<div class="pure-u-1">';
		$outstr .= '<div id="prompt" class="' . $message['class'] . '">' . $message['message'] . '</div>';
		$outstr .= '</div>';
		return $outstr;
	}
}
function item(){
	$outstr  = '<div class="item">';
	$outstr .= '<div class="pure-u-4-24 photo"></div>';
	$outstr .= '<div class="pure-u-16-24 content"><h2>Item test...</h2><p>' . lipsum() . '</p></div>';
	$outstr .= '<div class="pure-u-4-24 label">A<br/>01</div>';
	$outstr .= '</div>';
	return $outstr;
}
function csrf_name(){
	$CI = & get_instance();
	return $CI->security->get_csrf_token_name();
}
function csrf_hash(){
	$CI = & get_instance();
	return $CI->security->get_csrf_hash();
}
