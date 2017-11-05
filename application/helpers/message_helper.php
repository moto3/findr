<?php
function message($key, $params = array(), $language = 'us'){
	switch($key){
		case 'login_success':
			return 'Logged in successfully.';
		break;
		case 'login_failed':
			return 'Log in failed.';
		break;
		case 'please_login':
			return 'Please login to use this feature.';
		break;
		case 'already_logged_in':
			return 'You are already logged in.  Please log out.';
		break;

		case 'item_add_success':
			return 'Message added successfully.';
		break;
	}
}