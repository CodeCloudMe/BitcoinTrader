<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	

	ini_set('display_errors',1);  error_reporting(E_ALL); 
	session_start();
	$_SESSION['count'] =1;

	$store = false;
	if(!isset($_REQUEST['days'])){
		$store=true;
		$days=1;
	}
	else{

		$days= intval($_REQUEST['days']);

	}

	$resp = getPrices($days, $store);


	echo(json_encode($resp));




	//prop

	function getPrices($limit=1, $store){
		$data=array();
		$rData=array();
		//$startDate = "2012-01-01";
		for($i=0; $i<$limit; $i++){
			$theDate = date('Y-m-d');
			//echo($theDate);
			//echo("http://www.quandl.com/api/v1/datasets/BITCOIN/BITSTAMPUSD?auth_token=6sQU_EYPwHRMkJsReFG9");
			$info = file_get_contents("http://www.quandl.com/api/v1/datasets/BITCOIN/BITSTAMPUSD?auth_token=6sQU_EYPwHRMkJsReFG9");
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

			$rData = array("open"=>$open, "high"=>$high, "low"=>$low, "high"=>$high, "volume"=>$volume, "VolumeUSD"=>$volumeC, "weightedPrice"=>$weightedPrice, "avg"=>$avg, "close"=>$close, "exchange"=>"BitStamp");
			if($store ==true){
			dbQuery("INSERT INTO btcHistory (open, high, low, close, volume, volumeUSD, weightedPrice, avg, tDate) VALUES ($open, $high, $low, $close, $volume, $volumeC, $weightedPrice, $avg, '$theDate')");
				//echo("INSERT INTO btcHistory (open, high, low, close, volume, volumeUSD, weightedPrice, avg, tDate) VALUES ($open, $high, $low, $close, $volume, $volumeC, $weightedPrice, $avg, '$theDate')");
			}
			
		}
		//return true  
		return $rData;
	}


?>