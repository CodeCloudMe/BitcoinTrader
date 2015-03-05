<?php
include_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/beta/index.php');
extract($_REQUEST);
if(!isset($email)){

	$email="noEmail";
	echo(json_encode(array("status"=>"fail", "reason"=>"no email")));
	return;
}
else{
	beta($email);
	echo(json_encode(array("status"=>"success", "reason"=>"user added")));
}
	



?>