<?php

	require_once('/var/www/html/cloud/models/settings/update.php');
	


	$inputArr = $_REQUEST;
	session_start();
	extract($_REQUEST);


	//check for required variables
	if(!isset($action)){

		$resp = array("status"=>"fail", "reason"=>"please send an action");
		echo(json_encode($resp));
		return;
	}
	

	

	


	switch($action){


		case "update":
			$email = $_REQUEST['email'];
			$inputArr['passwd']= md5($inputArr['passwd']);
			$resp = updateAccount($inputArr);

			echo(json_encode($resp));
			exit;
		break;

		case "loggedin":

			
			$resp =isUserLoggedIn();
			echo(json_encode($resp));
			exit;

		break;


		default:

			$resp = array("status"=>"fail", "reason"=>"please send a valid action other than ". $action);

			echo json_encode($resp);

		break;
	}
?>