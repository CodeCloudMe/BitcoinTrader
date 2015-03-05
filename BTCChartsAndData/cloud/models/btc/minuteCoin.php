<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	

	ini_set('display_errors',1);  error_reporting(E_ALL); 
	session_start();
	$_SESSION['count'] =1;

	

	$resp = getPrices();


	echo(json_encode($resp));




	//prop

	function getPrices(){
		$data=array();
		$rData=array();
		//$startDate = "2012-01-01";

			$theDate = date('Y-m-d');
			//echo($theDate);
			//echo("http://www.quandl.com/api/v1/datasets/BITCOIN/BITSTAMPUSD?auth_token=6sQU_EYPwHRMkJsReFG9");
			$info = file_get_contents("https://www.bitstamp.net/api/ticker/");
			$tInfo = json_decode($info, true);

			$data = $tInfo;
			
			$high=floatval($data['high']);
			$low=floatval($data['low']);
			
			$volume=floatval($data['volume']);
			$ask=floatval($data['ask']);
			$bid=floatval($data['bid']);
			$current = floatval($data['last']);

			
			dbQuery("INSERT INTO minuteCoin ( high, low,  volume, ask, bid, current, tDate) VALUES ($high, $low, $volume, $ask, $bid, $current, '$theDate')");
				echo("INSERT INTO minuteCoin ( high, low,  volume, ask, bid, current, tDate) VALUES ($high, $low, $volume, $ask, $bid, $current, '$theDate')");
			
		
			$cex = file_get_contents("https://cex.io/api/ticker/BTC/USD");
			$tInfo1 = json_decode($cex, true);
			$cexPrice = floatval($tInfo1['last']);
			$cexLow = floatval($tInfo1['low']);
			$cexHigh = floatval($tInfo1['high']);
			$cexBid = floatval($tInfo1['bid']);
			$cexAsk = floatval($tInfo1['ask']);


				dbQuery("INSERT INTO minuteCEX ( current, high, low,  bid, ask, tDate) VALUES ($cexPrice, $cexHigh, $cexLow, $cexBid, $cexAsk, '$theDate')");
				echo("INSERT INTO minuteCEX ( current, high, low,  bid, ask, tDate) VALUES ($cexPrice, $cexHigh, $cexLow, $cexBid, $cexAsk, '$theDate')");

		//return true  
		return $rData;
	}


?>