<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/settings/index.php');
	


	$inputArr = $_REQUEST;
	session_start();
	extract($_REQUEST);


	//check for required variables
	if(!isset($action)){

		$resp = array("status"=>"fail", "reason"=>"please send an action");
		echo(json_encode($resp));
		return;
	}
	if(!isset($email)){

		$resp = array("status"=>"fail", "reason"=>"please send an email");
		echo(json_encode($resp));
		return;
	}

	if(!isset($passwd)){

		$resp = array("status"=>"fail", "reason"=>"please send a passwd");
		echo(json_encode($resp));
		return;
	}

	


	switch($action){


		case "add":
			$resp = createAccount($inputArr);

			echo(json_encode($resp));
		break;


		case "login":
			$resp = loginUser($email, $passwd);

			echo (json_encode($resp));


		break;


		case "logout":
			$resp = logout();

			echo (json_encode($resp));


		break;
		

		default:

			$resp = array("status"=>"fail", "reason"=>"please send a valid action");

			echo json_encode($resp);

		break;
	}

	


?>