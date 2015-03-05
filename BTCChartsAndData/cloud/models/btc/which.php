<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	

	//ini_set('display_errors',1);  error_reporting(E_ALL); 
	session_start();
	$_SESSION['count'] =1;


	extract($_REQUEST);

	if(!isset($which)){
		$which = 'minuteCoin';
	}
	if(!isset($col)){

		$col = 'current';
	}

	$what = retData($which, $col, $tick, $start, $end);

	echo(json_encode($what));


	function retData($which, $col, $tick, $start, $end){


		if(!isset($start)){
			$start= '2014-11-06 00:00:00';

		}

		if(!isset($end)){

			$end = date('Y-m-d H:i:s');
		}

		if(!isset($tick)){
			$tick = 5;
		}
		$tick = intval($tick);

		$resp = dbMassData("SELECT * FROM $which WHERE mod(minute(timestamp),$tick) = 0 AND timestamp < '$end' AND timestamp > '$start'");

		$resArr = array();
		for($i=0; $i<count($resp); $i++){

			array_push($resArr, $resp[$i][$col]);
		}

		return $resArr;




	}


?>