<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('access_check')){

	function login_check(){
		$CI =& get_instance();
		return $CI->session->userdata('logged_in');
	}
	function is_logged_in(){
		$CI =& get_instance();
		return $CI->session->userdata('logged_in');
	}
	function user_id(){
		$CI =& get_instance();
		return $CI->session->userdata('user_id');
	}
	function user_email(){
		$CI =& get_instance();
		return $CI->session->userdata('user_email');
	}
}