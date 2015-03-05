<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	

	ini_set('display_errors',1);  error_reporting(E_ALL); 
	session_start();
	$_SESSION['count'] =1;

	$resp = saveNews($_REQUEST);


	echo(json_encode($resp));



	//prop

	function saveNews($info){

		extract($info);

		$headline = addslashes($headline);
		$beginning =  addslashes($beginning);
		$link =  addslashes($link);
			dbQuery("INSERT INTO news (dateT, dateString, headline,beginning,link,topic) VALUES ('$dateT', '$dateString', '$headline','$beginning','$link','$topic')");
				echo("INSERT INTO news (dateT, dateString, headline,beginning,link,topic) VALUES ('$dateT', '$dateString', '$headline','$beginning','$link','$topic')");
			
			
		
		
		return true;
	}



?>