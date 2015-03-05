<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	

	ini_set('display_errors',1);  error_reporting(E_ALL); 
	session_start();
	$_SESSION['count'] =1;

	$resp = getPrices(365);


	echo(json_encode($resp));



	//prop

	function getPrices($limit=2){

		$startDate = "2012-01-01";
		for($i=0; $i<$limit; $i++){
			$theDate = date('Y-m-d', strtotime($startDate. ' + '.$i.' days'));
			echo($theDate);
			echo("time = http://www.quandl.com/api/v1/datasets/BITCOIN/BITSTAMPUSD?&trim_start=".$theDate."&trim_end=".$theDate. "&auth_token=6sQU_EYPwHRMkJsReFG9");
			$info = file_get_contents("http://www.quandl.com/api/v1/datasets/BITCOIN/BITSTAMPUSD?&trim_start=".$theDate."&trim_end=".$theDate."&auth_token=6sQU_EYPwHRMkJsReFG9");
			$tInfo = json_decode($info, true);

			$data = $tInfo['data'][0];
			$open= floatval($data[1]);
			$high=floatval($data[2]);
			$low=floatval($data[3]);
			$close=floatval($data[4]);
			$volume=floatval($data[5]);
			$volumeC=floatval($data[6]);
			$weightedPrice=floatval($data[7]);
			$avg = floatval(($high +$low)/2);

			dbQuery("INSERT INTO btcHistory (open, high, low, close, volume, volumeUSD, weightedPrice, avg, tDate) VALUES ($open, $high, $low, $close, $volume, $volumeC, $weightedPrice, $avg, '$theDate')");
				echo("INSERT INTO btcHistory (open, high, low, close, volume, volumeUSD, weightedPrice, avg, tDate) VALUES ($open, $high, $low, $close, $volume, $volumeC, $weightedPrice, $avg, '$theDate')");
		
			
		}
		
		return true;
	}



?>