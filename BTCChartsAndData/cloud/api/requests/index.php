<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/requests/index.php');
	


	$inputArr = $_REQUEST;
	
	$resp = sendRequest($inputArr);

	echo(json_encode($resp));

	$mailer = file_get_contents('http://travcork-maybe588.rhcloud.com/cloud/models/email/emailer.php?email='.$inputArr['email']);

	//echo($mailer);


?>