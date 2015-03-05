<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	

	ini_set('display_errors',1);  error_reporting(E_ALL); 
	session_start();
	$_SESSION['count'] =1;

	
	//$store = false;
	if(!isset($_REQUEST['id'])){
		$id=748136;
		
	}

	else{
		$id=intval($_REQUEST['id']);

	}

	$resp = seeIf($id);


	echo(json_encode($resp));




	//prop

	function seeIf($whichId){
		
		$resp1 = dbMassData("SELECT * FROM transactions WHERE id = $whichId ORDER BY timestamp DESC LIMIT 1");

		$theResp = array();
		if($resp1==null){


			$thePrice = dbMassData("SELECT * FROM minuteCoin ORDER BY timestamp DESC LIMIT 1");
			//not there
			$priceOh  = floatval($thePrice[0]['ask'])* 1.01;
			$thePrice =floatval($thePrice[0]['ask']);
			$thePrice = $thePrice +.05;
			$buyPriceNow =floatval($thePrice[0]['ask']);


			dbQuery("INSERT INTO transactions (price, sellPrice, active, id, which) VALUES ($thePrice, $priceOh, 'true', $whichId, 'buy' ) ");
			$theResp=array("active"=>"true", "bidWaiting"=>$priceOh, "buyPrice"=>$thePrice);

			return $theResp;

		}

		else if($resp1[0]['active']=="false"){

				$thePrice = dbMassData("SELECT * FROM minuteCoin ORDER BY timestamp DESC LIMIT 1");
			//not there
			$priceOh  = floatval($thePrice[0]['ask'])* 1.01;
			$thePrice =floatval($thePrice[0]['ask']);
			//ten cents higher
			$buyPriceNow =floatval($thePrice[0]['ask']);
			//place order for price oh




			dbQuery("INSERT INTO transactions (price, sellPrice, active, id, which) VALUES ($thePrice, $priceOh, 'true', $whichId, 'buy' ) ");
			
			//active is set to true but we return false so node triggers the buy order, and then the sell
			$theResp=array("active"=>"false", "bidWaiting"=>$priceOh, "buyPrice"=>$thePrice);

			return $theResp;

		}

		else{
			//
			$thePrice = dbMassData("SELECT * FROM minuteCoin ORDER BY timestamp DESC LIMIT 1");
			
			
			//set all to false to prevent bullshit
			if(floatval($thePrice[0]['current']) >= floatval($resp1[0]['sellPrice']) ){
				
				//time to trade!
				dbQuery("UPDATE transactions SET active = 'false', which='sold' WHERE id=$whichId");
				$theResp=array("active"=>"false");
			}
			else{
				dbQuery("UPDATE transactions SET active = 'true' WHERE id = $whichId");
				$theResp=array("active"=>"true", "waitingFor"=>floatval($resp1[0]['sellPrice']));
			}
			
			return $theResp;

		}



	}


?>