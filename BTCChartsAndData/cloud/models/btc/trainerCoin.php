<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	

	//ini_set('display_errors',1);  error_reporting(E_ALL); 
	//session_start();
	//$_SESSION['count'] =1;

	extract($_REQUEST);
	if(!isset($limit)){

			$limit=15;
	}

	if(!isset($tick)){

			$tick=5;
	}
	else{
		$tick = intval($tick);
	}

	if(!isset($whatsBetter)){

			$whatBetter=.01;
	}
	else{
		$whatsBetter = floatval($whatsBetter);
	}


	$resp = getCData($limit, $tick);

	if(!isset($_GET['callback'])){

			echo(json_encode($resp));

			return;
	}
	else{
			echo($_GET['callback'] . '(' .json_encode($resp).')');
			return;
	}




	function getCData($limit, $tick, $whatBetter){
		$limit = intval($limit);

		//$news = dbMassData("SELECT * FROM news WHERE dateT !='0000-00-00 00:00:00' GROUP BY dateT ORDER BY dateT ASC");
		$prices = dbMassData("SELECT * FROM minuteCoin WHERE mod(minute(timestamp),$tick) AND tDate != '0000-00-00 00:00:00' ORDER BY timestamp DESC LIMIT 1000");
		$prices = array_reverse($prices);
		$respArr=array("buy"=>array(), "dont"=>array());
		for($i=0; $i<count($prices); $i++){

				$outOne = $i+$limit;
				$startPrice = floatval($prices[$i]['ask']);
				$endPrice = floatval($prices[$outOne]['bid']);

				if($endPrice > ($startPrice +($startPrice*$whatsBetter))){
					$thisBlock = array("bidsAfter"=>array(), "bidsRateBefore"=>array(), "bidsRateAfter"=>array(), "bidsBefore"=>array(), "asksAfter"=>array(), "asksBefore"=>array(), "asksRateBefore"=>array(), "asksRateAfter"=>array(), "pricesAfter"=>array(), "pricesBefore"=>array(), "pricesRateBefore"=>array(), "pricesRateAfter"=>array(), "spreadAfter"=>array(), "spreadBefore"=>array());
					$startingPoint = $i;
					try{
					for($j=0; $j<$limit; $j++){

						$thisOne= $startingPoint+$j;
						$oneBefore = $thisOne-1;
						array_push($thisBlock['bidsAfter'], floatval($prices[$thisOne]['bid']));
						array_push($thisBlock['asksAfter'], floatval($prices[$thisOne]['ask']));
						array_push($thisBlock['pricesAfter'], floatval($prices[$thisOne]['current']));

						$bidsRateAfter= sqrt((floatval($prices[$thisOne]['bid'])/floatval($prices[$oneBefore]['bid'])) )*.5;
						$asksRateAfter= sqrt((floatval($prices[$thisOne]['ask'])/floatval($prices[$oneBefore]['ask'])) )*.5;
						$pricesRateAfter=sqrt((floatval($prices[$thisOne]['current'])/floatval($prices[$oneBefore]['current'])) )*.5;

						$spreadAfter = floatval($prices[$thisOne]['bid'])/ floatval($prices[$thisOne]['ask']);

						array_push($thisBlock['bidsRateAfter'], $bidsRateAfter );
						array_push($thisBlock['asksRateAfter'], $asksRateAfter );
						array_push($thisBlock['pricesRateAfter'], $pricesRateAfter);
						array_push($thisBlock['spreadAfter'], $spreadAfter);


					}
//get fifteen before

					for($j=$limit; $j >0; $j--){

						$thisOne= $startingPoint-$j;
						$oneBefore = $thisOne-1;
						array_push($thisBlock['bidsBefore'], floatval($prices[$thisOne]['bid']));
						array_push($thisBlock['asksBefore'], floatval($prices[$thisOne]['ask']));
						array_push($thisBlock['pricesBefore'], floatval($prices[$thisOne]['current']));

						$bidsRateBefore = sqrt((floatval($prices[$thisOne]['bid'])/floatval($prices[$oneBefore]['bid'])) ) *.5;
						$asksRateBefore= sqrt((floatval($prices[$thisOne]['ask'])/floatval($prices[$oneBefore]['ask']))  ) *.5;
						$pricesRateBefore=sqrt((floatval($prices[$thisOne]['current'])/floatval($prices[$oneBefore]['current']))) *.5;
						$spreadBefore = floatval($prices[$thisOne]['bid'])/ floatval($prices[$thisOne]['ask']);

						array_push($thisBlock['bidsRateBefore'], $bidsRateBefore );
						array_push($thisBlock['asksRateBefore'], $asksRateBefore);
						array_push($thisBlock['pricesRateBefore'], $pricesRateBefore);
						array_push($thisBlock['spreadBefore'], $spreadBefore);


					}

					}
					catch(Exception $e){

					}

					array_push($respArr['buy'], $thisBlock);
				}


				else{
					$thisBlock = array("bidsAfter"=>array(), "bidsRateBefore"=>array(), "bidsRateAfter"=>array(), "bidsBefore"=>array(), "asksAfter"=>array(), "asksBefore"=>array(), "asksRateBefore"=>array(), "asksRateAfter"=>array(), "pricesAfter"=>array(), "pricesBefore"=>array(), "pricesRateBefore"=>array(), "pricesRateAfter"=>array(), "spreadBefore"=>array(), "spreadAfter"=>array());
					$startingPoint = $i;
					try{
					for($j=0; $j<$limit; $j++){

						$thisOne= $startingPoint+$j;
						$oneBefore = $thisOne-1;
						array_push($thisBlock['bidsAfter'], floatval($prices[$thisOne]['bid']));
						array_push($thisBlock['asksAfter'], floatval($prices[$thisOne]['ask']));
						array_push($thisBlock['pricesAfter'], floatval($prices[$thisOne]['current']));

						$bidsRateAfter= sqrt((floatval($prices[$thisOne]['bid'])/floatval($prices[$oneBefore]['bid'])) )*.5;
						$asksRateAfter= sqrt((floatval($prices[$thisOne]['ask'])/floatval($prices[$oneBefore]['ask'])) )*.5;
						$pricesRateAfter=sqrt((floatval($prices[$thisOne]['current'])/floatval($prices[$oneBefore]['current'])) )*.5;
						$spreadAfter = floatval($prices[$thisOne]['bid'])/ floatval($prices[$thisOne]['ask']);

						array_push($thisBlock['bidsRateAfter'], $bidsRateAfter );
						array_push($thisBlock['asksRateAfter'], $asksRateAfter );
						array_push($thisBlock['pricesRateAfter'], $pricesRateAfter);
						array_push($thisBlock['spreadAfter'], $spreadAfter);


					}
//get fifteen before

					for($j=$limit; $j >0; $j--){

						$thisOne= $startingPoint-$j;
						$oneBefore = $thisOne-1;
						array_push($thisBlock['bidsBefore'], floatval($prices[$thisOne]['bid']));
						array_push($thisBlock['asksBefore'], floatval($prices[$thisOne]['ask']));
						array_push($thisBlock['pricesBefore'], floatval($prices[$thisOne]['current']));

						$bidsRateBefore = sqrt((floatval($prices[$thisOne]['bid'])/floatval($prices[$oneBefore]['bid'])) ) *.5;
						$asksRateBefore= sqrt((floatval($prices[$thisOne]['ask'])/floatval($prices[$oneBefore]['ask']))  ) *.5;
						$pricesRateBefore=sqrt((floatval($prices[$thisOne]['current'])/floatval($prices[$oneBefore]['current']))) *.5;
						$spreadBefore = floatval($prices[$thisOne]['bid'])/ floatval($prices[$thisOne]['ask']);

						array_push($thisBlock['bidsRateBefore'], $bidsRateBefore );
						array_push($thisBlock['asksRateBefore'], $asksRateBefore);
						array_push($thisBlock['pricesRateBefore'], $pricesRateBefore);
						array_push($thisBlock['spreadBefore'], $spreadBefore);


					}

					}
					catch(Exception $e){

					}

					array_push($respArr['dont'], $thisBlock);
				}



				

		}
		$resp = array("blocks"=>$respArr);

		return $resp;
	}



?>