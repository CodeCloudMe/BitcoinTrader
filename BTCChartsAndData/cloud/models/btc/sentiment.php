<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	

	ini_set('display_errors',1);  error_reporting(E_ALL); 
	session_start();
	$_SESSION['count'] =1;

	$resp = getSent();


	echo(json_encode($resp));


	function getSent(){


		$data = dbMassData("SELECT * FROM news ORDER BY dateT DESC");

		for($i=0; $i<count($data); $i++){

			$info1 = $data[$i]['headline']. " ". $data[$i]['beginning'];
			$senti = file_get_contents("http://alina-prod.apigee.net/sentiment?info1=".urlencode($info1)."&apikey=npIZYYxsfzE0DOVX92oEPwGTV95wg7X6");
			$sentiment = json_decode($senti, true);
			$score = $sentiment['data']['score'];
			$cScore = $sentiment['data']['comparative'];
			$rId = $data[$i]['rId'];
			dbQuery("UPDATE news SET sentiment = $score, comparative= $cScore WHERE rId = $rId ");
			echo("UPDATE news SET sentiment = $score, comparative= $cScore WHERE rId = $rId ");
			echo("<br>");

		}

		return true;
	}


?>