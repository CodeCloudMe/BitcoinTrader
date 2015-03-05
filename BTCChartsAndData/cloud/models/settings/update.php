<?php

	
	require_once('/var/www/html/cloud/models/main/index.php');
	


	/* debug */

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
	//$resp = createOrder(array("itemId"=>"1", "userId"=>"1"));
	//$userInfo = array("email"=>"m@m.com", "password"=>"password");
	//$resp = createAccount($userInfo);
	//$resp = loginUser('m@m.com', 'password');

	//$resp = getMyOrders("1");
	//$resp = getFeatItems('kitchen');
//print_r($resp);



	function createAccount($userInfo){
		//echo('creating...');
		if(!isset($userInfo['email'])){
			$resp = array("status"=>"fail", "reason"=>"please send the email to create account");
			return $resp;

		}

		if(!isset($userInfo['passwd'])){
			$resp = array("status"=>"fail", "reason"=>"please send password to create account");
			return $resp;

		}

		 $userInfo['userId'] = generateRandomString();

		 $unencrypted = $userInfo['passwd'];
		$userInfo['passwd']= md5($userInfo['passwd']);

		$email  = $userInfo['email'];
		$exists = dbMassData("SELECT * FROM settings WHERE email = '$email'");

		if($exists != NULL){

			 $account = loginUser($email, $unencrypted );
			 return $account; 

		}


		rollAdd('settings', $userInfo, FALSE, FALSE ,FALSE, FALSE, TRUE);

		$resp = array("status"=>"success", "reason"=>"account created");
			return $resp;



	}

	function isUserLoggedIn(){

		session_start();

		if(!isset($_SESSION['userId'])){

			 $resp = array("status"=>"fail", "reason"=>"user not logged");
			 return $resp;
		}
		else{
			$email = $_SESSION['email'];
			$userData = dbMassData("SELECT * FROM settings WHERE email = '$email'");
			$userData = $userData[0];
			$resp = array("status"=>"success", "reason"=>"user logged in", "data"=>$userData);
			 return $resp;

		}
	}


	function updateAccount($userInfo){
		extract($_REQUEST);
		$exists = dbMassData("SELECT * FROM settings WHERE email = '$email'");

		if($exists == NULL){

			 $resp = array("status"=>"fail", 'reason'=>"user has wrong credentials");
			 return $resp;
		}

		else{
			session_start();
			$email=$userInfo['email'];
			$userInfo = array("email"=>$email)+ $userInfo;
			rollAdd('settings', $userInfo, FALSE, FALSE ,FALSE, TRUE, TRUE);


			$resp = array("status"=>"success", 'reason'=>"user info updated");
			 return $resp;
		}


	}

	function addCreditCard($userId, $credItInfo){


		dbQuery("UPDATE orders SET status = 'cancelled' WHERE rId = $whichId");
		$resp = array("status"=>"success", "reason"=>"this order was cancelled");
			return $resp;


	}



	function loginUser($email, $pass){

		$pass= md5($pass);
		$userAccount = dbMassData("SELECT * FROM settings WHERE email = '$email' AND passwd= '$pass'");
		if($userAccount ==NULL){

			$resp = array("status"=>"fail", "reason"=>"invalid credentials");
			return $resp;

			//password/email not valid
		}

		else{
			$resp = array("status"=>"success", "data"=>$userAccount[0], "reason"=>"invalid credentials");
			
			session_id();
			session_start();
			$_SESSION['userId'] = $userAccount[0]['userId'];
			$_SESSION['rId'] = $userAccount[0]['rId'];
			$_SESSION['email'] = $userAccount[0]['email'];

			return $resp;

		}

	}


	function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>