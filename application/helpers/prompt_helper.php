<?php
function echo_prompt($success, $message){
	$ret = array();
  $ret['success'] = $success;
  $ret['message'] = $message;
  echo json_encode($ret);
}