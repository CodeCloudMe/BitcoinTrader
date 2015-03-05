<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	


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
		$exists = dbMassData("SELECT * FROM users WHERE email = '$email'");

		if($exists != NULL){

			 $account = loginUser($email, $unencrypted );
			 return $account; 

		}

		$passwd= $userInfo['passwd'];
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		dbQuery("INSERT INTO users (email, passwd, ip) VALUES('$email', '$passwd', '$ip')");
		//$resp = array("status"=>"success", "reason"=>"account created");
			//return $resp;

		 $account = loginUser($email, $unencrypted );
		return $account; 




	}


	function logout(){

		session_start();

		// Delete certain session
		unset($_SESSION['rId']);
		unset($_SESSION['userId']);
		unset($_SESSION['email']);
			$resp = array("status"=>"success", "reason"=>"user logged out");
			return $resp;
	}




	function addCreditCard($userId, $credItInfo){


		dbQuery("UPDATE orders SET status = 'cancelled' WHERE rId = $whichId");
		$resp = array("status"=>"success", "reason"=>"this order was cancelled");
			return $resp;


	}



	function loginUser($email, $pass){

		$pass= md5($pass);
		$userAccount = dbMassData("SELECT * FROM users WHERE email = '$email' AND passwd= '$pass'");
		if($userAccount ==NULL){

			$resp = array("status"=>"fail", "reason"=>"invalid credentials");
			return $resp;

			//password/email not valid
		}

		else{
			$resp = array("status"=>"success", "data"=>$userAccount[0], "reason"=>"user logged in");
			
			session_id();
			session_start();
			$_SESSION['userId'] = $userAccount[0]['rId'];
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